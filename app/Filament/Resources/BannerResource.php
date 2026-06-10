<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo'; // Changed for better context

    protected static ?string $navigationGroup = 'Manajemen Web';

    protected static ?string $navigationLabel = 'Banner';

    protected static ?string $modelLabel = 'Banner';

    protected static ?string $pluralModelLabel = 'Banner';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main column for text content
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Rincian Banner')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul')
                                    ->maxLength(255)
                                    ->default(null),
                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi')
                                    ->rows(5) // Set a specific height for the textarea
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                // Sidebar for image and status
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Gambar')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Unggah Gambar')
                                    ->image()
                                    ->imageEditor() // Add image editor for convenience
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true) // Set the default value to active
                                    ->required(),
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
                    ->circular()
                    ->height(50),
                // Changed from IconColumn to ToggleColumn for inline editing
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Status Aktif'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40)
                    // Fix: Use the null coalescing operator to provide an empty string if title is null
                    ->tooltip(fn (Banner $record): string => $record->title ?? ''),
            ])
            ->filters([
                //
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
