<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaResource\Pages;
use App\Filament\Resources\BeritaResource\RelationManagers;
use App\Models\Berita;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Manajemen Web';

    protected static ?string $navigationLabel = 'Berita';

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita';

    // protected static ?string $navigationGroup = 'Content'; // Kept as commented out per user's last edit

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main content column
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Konten Berita')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Berita')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                    ->suffixAction(
                                        Forms\Components\Actions\Action::make('generate_ai')
                                            ->label('Tulis dengan AI')
                                            ->icon('heroicon-m-sparkles')
                                            ->color('primary')
                                            ->form(fn (Forms\Get $get) => [
                                                Forms\Components\Toggle::make('use_current_title')
                                                    ->label('Sesuaikan dengan Judul Saat Ini')
                                                    ->default(!empty($get('title')))
                                                    ->live()
                                                    ->helperText('AI akan menulis isi berita yang fokus dan sesuai dengan judul yang sudah Anda isi di atas tanpa mengubah judulnya.'),
                                                Forms\Components\Textarea::make('prompt')
                                                    ->label('Kata Kunci / Topik / Berita Mentah')
                                                    ->placeholder('Masukkan topik berita atau salin teks berita mentah di sini...')
                                                    ->rows(6)
                                                    ->default($get('title'))
                                                    ->required(),
                                                Forms\Components\Select::make('tone')
                                                    ->label('Gaya Bahasa / Tone')
                                                    ->options([
                                                        'formal' => 'Resmi / Jurnalistik',
                                                        'informal' => 'Santai / Populer',
                                                        'professional' => 'Profesional / Edukatif',
                                                    ])
                                                    ->default('formal')
                                                    ->required(),
                                            ])
                                            ->action(function (array $data, Forms\Get $get, Forms\Set $set) {
                                                try {
                                                    $originalTitle = $get('title');
                                                    $prompt = $data['prompt'];

                                                    if (!empty($data['use_current_title']) && !empty($originalTitle)) {
                                                        $prompt = "Judul Berita: " . $originalTitle . "\n\nInstruksi Penting: Tulis artikel berita dengan judul tersebut dan pastikan isi berita berfokus dan sesuai dengan judul tersebut. Jangan mengubah atau membuat judul baru.\n\nKata Kunci Tambahan:\n" . $prompt;
                                                    }

                                                    $result = \App\Services\GeminiService::generateNews($prompt, $data['tone']);
                                                    
                                                    if ($result) {
                                                        if (!empty($data['use_current_title']) && !empty($originalTitle)) {
                                                            // Keep user's title
                                                            $set('title', $originalTitle);
                                                            $set('slug', Str::slug($originalTitle));
                                                        } else {
                                                            // Use AI's title
                                                            $set('title', $result['title']);
                                                            $set('slug', Str::slug($result['title']));
                                                        }
                                                        
                                                        $set('content', $result['content']);
                                                        
                                                        \Filament\Notifications\Notification::make()
                                                            ->title('Berita AI Berhasil Dibuat!')
                                                            ->body('Judul dan konten berita telah terisi otomatis.')
                                                            ->success()
                                                            ->send();
                                                    }
                                                } catch (\Exception $e) {
                                                    \Filament\Notifications\Notification::make()
                                                        ->title('Gagal Membuat Berita AI')
                                                        ->body($e->getMessage())
                                                        ->danger()
                                                        ->persistent()
                                                        ->send();
                                                }
                                            })
                                    ),
 
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug / Tautan Unik')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Berita::class, 'slug', ignoreRecord: true)
                                    ->readOnly(),
 
                                TinyEditor::make('content')
                                    ->label('Isi Konten')
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsVisibility('public')
                                    ->fileAttachmentsDirectory('uploads')
                                    ->profile('full')
                                    ->columnSpan('full')
                                    ->required(),
                            ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                // Sidebar column
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Gambar Utama')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Unggah Gambar')
                                    ->image()
                                    ->imageEditor()
                                    ->required(),
                            ]),
                        // New Section for Status (Publish/Draft)
                        Forms\Components\Section::make('Status Publikasi')
                            ->schema([
                                Forms\Components\Toggle::make('is_published')
                                    ->label('Publikasikan')
                                    ->default(true)
                                    ->live(),
 
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Tanggal Publikasi')
                                    ->default(now())
                                    ->required()
                                    // Show this field only when 'is_published' is toggled on
                                    ->visible(fn (callable $get) => $get('is_published')),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No')->rowIndex(),
                Tables\Columns\ImageColumn::make('image')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Berita')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                // New column to show publish status
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Diterbitkan Pada')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // New filter to sort by status
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Diterbitkan')
                    ->falseLabel('Draf')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
}
