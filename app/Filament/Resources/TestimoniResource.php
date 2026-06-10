<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimoniResource\Pages;
use App\Models\Testimoni;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TestimoniResource extends Resource
{
    protected static ?string $model = Testimoni::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Testimoni';

    protected static ?string $navigationGroup = 'Feedback';

    protected static ?string $modelLabel = 'Testimoni';

    protected static ?string $pluralModelLabel = 'Testimoni';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main column for testimonial content
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Rincian Testimoni')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('institution')
                                    ->label('Instansi/Pekerjaan')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('quote')
                                    ->label('Isi Testimoni')
                                    ->required()
                                    ->rows(8)
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                // Sidebar for media
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Media')
                            ->schema([
                                Forms\Components\FileUpload::make('photo')
                                    ->label('Foto')
                                    ->image()
                                    ->disk('public')
                                    ->directory('testimoni/photos')
                                    ->nullable()
                                    ->maxSize(5120) // 5MB
                                    ->helperText('Format: JPG, PNG, GIF (Max: 5MB)'),
                                
                                Forms\Components\FileUpload::make('video')
                                    ->label('Video Testimoni')
                                    ->disk('public')
                                    ->directory('testimoni/videos')
                                    ->acceptedFileTypes(['video/*'])
                                    ->maxSize(1024 * 50) // 50MB
                                    ->nullable()
                                    ->helperText('Upload video testimoni (Max: 50MB)')
                                    ->visibility('public'),
                                
                                Forms\Components\TextInput::make('youtube_url')
                                    ->label('URL YouTube (Opsional)')
                                    ->url()
                                    ->nullable()
                                    ->maxLength(255)
                                    ->helperText('Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ')
                                    ->placeholder('https://www.youtube.com/watch?v=...'),
                                
                                Forms\Components\Placeholder::make('info')
                                    ->label('')
                                    ->content('Prioritas: Video lokal > YouTube URL. Jika keduanya diisi, video lokal akan ditampilkan.')
                                    ->helperText('Pastikan video berformat MP4, AVI, MOV, atau WEBM'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular()
                    ->size(50),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('institution')
                    ->label('Instansi')
                    ->searchable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('quote')
                    ->label('Testimoni')
                    ->limit(50)
                    ->tooltip(function (Testimoni $record): string {
                        return $record->quote;
                    }),
                
                Tables\Columns\IconColumn::make('has_video')
                    ->label('Video')
                    ->boolean()
                    ->getStateUsing(function (Testimoni $record): bool {
                        return !empty($record->video);
                    })
                    ->trueIcon('heroicon-o-video-camera')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('success')
                    ->falseColor('gray'),
                
                Tables\Columns\IconColumn::make('has_youtube')
                    ->label('YouTube')
                    ->boolean()
                    ->getStateUsing(function (Testimoni $record): bool {
                        return !empty($record->youtube_url);
                    })
                    ->trueIcon('heroicon-o-play')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('danger')
                    ->falseColor('gray'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('has_media')
                    ->label('Jenis Media')
                    ->options([
                        'video' => 'Memiliki Video',
                        'youtube' => 'Memiliki YouTube',
                        'no_media' => 'Tanpa Media',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] === 'video',
                            fn (Builder $query): Builder => $query->whereNotNull('video')
                        )->when(
                            $data['value'] === 'youtube',
                            fn (Builder $query): Builder => $query->whereNotNull('youtube_url')
                        )->when(
                            $data['value'] === 'no_media',
                            fn (Builder $query): Builder => $query->whereNull('video')->whereNull('youtube_url')
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->label('Aksi'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Belum Ada Testimoni')
            ->emptyStateDescription('Testimoni dari masyarakat akan muncul di sini')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-right');
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonis::route('/'),
            'create' => Pages\CreateTestimoni::route('/create'),
            'view' => Pages\ViewTestimoni::route('/{record}'),
            'edit' => Pages\EditTestimoni::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}