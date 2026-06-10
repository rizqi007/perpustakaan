<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationMenuResource\Pages;
use App\Models\NavigationMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NavigationMenuResource extends Resource
{
    protected static ?string $model = NavigationMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'Navigasi Situs';

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Navigasi Situs';

    protected static ?string $pluralModelLabel = 'Navigasi Situs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Menu')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->label('Label Menu')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('contoh: Beranda'),

                        Forms\Components\Select::make('parent_id')
                            ->label('Menu Induk')
                            ->options(fn (?NavigationMenu $record) => self::getParentOptions($record))
                            ->nullable()
                            ->placeholder('— Tidak ada (Menu Utama) —')
                            ->helperText('Pilih menu induk untuk membuat sub-menu / dropdown'),

                        Forms\Components\TextInput::make('url')
                            ->label('URL / Link')
                            ->maxLength(255)
                            ->placeholder('contoh: /berita atau https://google.com')
                            ->helperText('Isi URL langsung, atau gunakan Nama Route di bawah'),

                        Forms\Components\TextInput::make('route_name')
                            ->label('Nama Route Laravel')
                            ->maxLength(255)
                            ->placeholder('contoh: landing, berita.index, contact')
                            ->helperText('Prioritas lebih tinggi dari URL jika diisi'),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil, semakin di depan'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan untuk menyembunyikan menu'),

                        Forms\Components\Toggle::make('open_in_new_tab')
                            ->label('Buka di Tab Baru')
                            ->default(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('label')
                    ->label('Label Menu')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (NavigationMenu $record) => $record->parent ? '↳ Sub-menu dari: ' . $record->parent->label : null),

                Tables\Columns\TextColumn::make('resolved_url')
                    ->label('URL')
                    ->limit(40)
                    ->color('primary')
                    ->tooltip(fn (NavigationMenu $record) => $record->resolved_url),

                Tables\Columns\TextColumn::make('route_name')
                    ->label('Route')
                    ->badge()
                    ->color('info')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('parent.label')
                    ->label('Menu Induk')
                    ->placeholder('— Root —')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('open_in_new_tab')
                    ->label('Tab Baru')
                    ->formatStateUsing(fn ($state) => $state ? 'Ya' : 'Tidak')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Tipe')
                    ->options([
                        'root' => 'Menu Utama',
                        'child' => 'Sub-Menu',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value'] === 'root') {
                            $query->whereNull('parent_id');
                        } elseif ($data['value'] === 'child') {
                            $query->whereNotNull('parent_id');
                        }
                    }),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigationMenus::route('/'),
            'create' => Pages\CreateNavigationMenu::route('/create'),
            'edit' => Pages\EditNavigationMenu::route('/{record}/edit'),
        ];
    }

    public static function getParentOptions(?NavigationMenu $currentRecord = null): array
    {
        $options = [];

        $roots = NavigationMenu::whereNull('parent_id')
            ->when($currentRecord, fn ($q) => $q->where('id', '!=', $currentRecord->id))
            ->orderBy('order')
            ->get();

        foreach ($roots as $root) {
            $options[$root->id] = $root->label;

            $children = NavigationMenu::where('parent_id', $root->id)
                ->when($currentRecord, fn ($q) => $q->where('id', '!=', $currentRecord->id))
                ->orderBy('order')
                ->get();

            foreach ($children as $child) {
                $options[$child->id] = "— " . $child->label;
            }
        }

        return $options;
    }
}
