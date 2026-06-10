<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardTemplateResource\Pages;
use App\Models\CardTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class CardTemplateResource extends Resource
{
    protected static ?string $model = CardTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Template Kartu';

    protected static ?string $navigationGroup = 'Manajemen User';

    protected static ?string $modelLabel = 'Template Kartu';

    protected static ?string $pluralModelLabel = 'Template Kartu';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Template')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Template Kartu Hijau'),
                        Forms\Components\Select::make('orientation')
                            ->label('Orientasi')
                            ->options([
                                'horizontal' => 'Horizontal (Landscape)',
                                'vertical' => 'Vertikal (Portrait)',
                            ])
                            ->default('horizontal')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktifkan Template')
                            ->helperText('Hanya satu template yang bisa aktif. Mengaktifkan ini akan menonaktifkan template lain.')
                            ->default(false),
                    ])->columns(2),

                Forms\Components\Section::make('Background & Overlay')
                    ->schema([
                        Forms\Components\FileUpload::make('background_image')
                            ->label('Gambar Background')
                            ->image()
                            ->directory('card-templates')
                            ->maxSize(5120)
                            ->nullable()
                            ->helperText('Upload gambar background kartu (maks. 5MB). Jika kosong, akan menggunakan desain gradient default.')
                            ->columnSpanFull(),
                        Forms\Components\ColorPicker::make('overlay_color')
                            ->label('Warna Overlay')
                            ->default('#047857'),
                        Forms\Components\TextInput::make('overlay_opacity')
                            ->label('Opacity Overlay')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(1)
                            ->step(0.1)
                            ->default(0.7)
                            ->helperText('Nilai 0 (transparan) - 1 (solid)'),
                    ])->columns(2),

                Forms\Components\Section::make('Posisi Logo')
                    ->description('Posisi logo dalam persen (%) dari ukuran kartu')
                    ->schema([
                        Forms\Components\TextInput::make('logo_position.x')
                            ->label('X (%)')
                            ->numeric()
                            ->default(5)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('logo_position.y')
                            ->label('Y (%)')
                            ->numeric()
                            ->default(5)
                            ->minValue(0)
                            ->maxValue(100),
                    ])->columns(2)->collapsible(),

                Forms\Components\Section::make('Posisi Foto')
                    ->description('Posisi dan ukuran foto anggota dalam persen (%) dari ukuran kartu')
                    ->schema([
                        Forms\Components\TextInput::make('photo_position.x')
                            ->label('X (%)')
                            ->numeric()
                            ->default(5)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('photo_position.y')
                            ->label('Y (%)')
                            ->numeric()
                            ->default(30)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('photo_position.width')
                            ->label('Lebar (%)')
                            ->numeric()
                            ->default(20)
                            ->minValue(5)
                            ->maxValue(80),
                        Forms\Components\TextInput::make('photo_position.height')
                            ->label('Tinggi (%)')
                            ->numeric()
                            ->default(40)
                            ->minValue(5)
                            ->maxValue(80),
                    ])->columns(4)->collapsible(),

                Forms\Components\Section::make('Posisi Nama')
                    ->description('Posisi teks nama anggota')
                    ->schema([
                        Forms\Components\TextInput::make('name_position.x')
                            ->label('X (%)')
                            ->numeric()
                            ->default(30)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('name_position.y')
                            ->label('Y (%)')
                            ->numeric()
                            ->default(35)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('name_position.fontSize')
                            ->label('Ukuran Font (px)')
                            ->numeric()
                            ->default(14)
                            ->minValue(8)
                            ->maxValue(48),
                        Forms\Components\ColorPicker::make('name_position.color')
                            ->label('Warna Teks')
                            ->default('#ffffff'),
                    ])->columns(4)->collapsible(),

                Forms\Components\Section::make('Posisi NIP')
                    ->description('Posisi teks NIP/ID anggota')
                    ->schema([
                        Forms\Components\TextInput::make('nip_position.x')
                            ->label('X (%)')
                            ->numeric()
                            ->default(30)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('nip_position.y')
                            ->label('Y (%)')
                            ->numeric()
                            ->default(50)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('nip_position.fontSize')
                            ->label('Ukuran Font (px)')
                            ->numeric()
                            ->default(16)
                            ->minValue(8)
                            ->maxValue(48),
                        Forms\Components\ColorPicker::make('nip_position.color')
                            ->label('Warna Teks')
                            ->default('#ffffff'),
                    ])->columns(4)->collapsible(),

                Forms\Components\Section::make('Posisi Institusi')
                    ->description('Posisi teks institusi/satuan kerja')
                    ->schema([
                        Forms\Components\TextInput::make('institution_position.x')
                            ->label('X (%)')
                            ->numeric()
                            ->default(30)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('institution_position.y')
                            ->label('Y (%)')
                            ->numeric()
                            ->default(62)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('institution_position.fontSize')
                            ->label('Ukuran Font (px)')
                            ->numeric()
                            ->default(11)
                            ->minValue(8)
                            ->maxValue(48),
                        Forms\Components\ColorPicker::make('institution_position.color')
                            ->label('Warna Teks')
                            ->default('#ffffff'),
                    ])->columns(4)->collapsible(),

                Forms\Components\Section::make('Posisi Masa Berlaku')
                    ->description('Posisi teks tanggal berlaku kartu')
                    ->schema([
                        Forms\Components\TextInput::make('validity_position.x')
                            ->label('X (%)')
                            ->numeric()
                            ->default(5)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('validity_position.y')
                            ->label('Y (%)')
                            ->numeric()
                            ->default(90)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('validity_position.fontSize')
                            ->label('Ukuran Font (px)')
                            ->numeric()
                            ->default(8)
                            ->minValue(6)
                            ->maxValue(24),
                        Forms\Components\ColorPicker::make('validity_position.color')
                            ->label('Warna Teks')
                            ->default('#ffffff'),
                    ])->columns(4)->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('background_image')
                    ->label('Preview')
                    ->width(80)
                    ->height(50)
                    ->defaultImageUrl(fn () => 'https://via.placeholder.com/80x50/047857/ffffff?text=Default'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Template')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('orientation')
                    ->label('Orientasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'horizontal' => 'info',
                        'vertical' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'horizontal' => 'Horizontal',
                        'vertical' => 'Vertikal',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('activate')
                    ->label('Aktifkan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Aktifkan Template')
                    ->modalDescription(fn (CardTemplate $record) => "Aktifkan template \"{$record->name}\"? Template lain akan dinonaktifkan.")
                    ->visible(fn (CardTemplate $record) => !$record->is_active)
                    ->action(function (CardTemplate $record) {
                        $record->activate();

                        Notification::make()
                            ->title('Template Diaktifkan')
                            ->body("Template \"{$record->name}\" sekarang aktif.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('deactivate')
                    ->label('Nonaktifkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Nonaktifkan Template')
                    ->modalDescription(fn (CardTemplate $record) => "Nonaktifkan template \"{$record->name}\"? Kartu anggota akan menggunakan desain default.")
                    ->visible(fn (CardTemplate $record) => $record->is_active)
                    ->action(function (CardTemplate $record) {
                        $record->deactivate();

                        Notification::make()
                            ->title('Template Dinonaktifkan')
                            ->body('Kartu anggota akan menggunakan desain default.')
                            ->warning()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCardTemplates::route('/'),
            'create' => Pages\CreateCardTemplate::route('/create'),
            'edit' => Pages\EditCardTemplate::route('/{record}/edit'),
        ];
    }
}
