<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LayananResource\Pages;
use App\Filament\Resources\LayananResource\RelationManagers;
use App\Models\Layanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt'; // Changed for better context

    protected static ?string $navigationGroup = 'Manajemen Web';

    protected static ?string $navigationLabel = 'Layanan';

    protected static ?string $modelLabel = 'Layanan';

    protected static ?string $pluralModelLabel = 'Layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main column for details
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Rincian Layanan')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Layanan')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi')
                                    ->rows(3)
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('type')
                                    ->label('Tipe Layanan')
                                    ->options([
                                        'perpustakaan' => 'Layanan Perpustakaan',
                                        'open_resource' => 'Open Resource',
                                    ])
                                    ->required()
                                    ->default('perpustakaan'),
                                Forms\Components\TextInput::make('url')
                                    ->label('URL')
                                    ->url() // Add URL validation
                                    ->maxLength(255),
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                // Sidebar for image
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
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No')->rowIndex(),
                Tables\Columns\ImageColumn::make('image')
                    ->square()
                    ->label('Gambar'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama Layanan'),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->url(fn(Layanan $record) => $record->url, true), // Make the URL clickable
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
            'index' => Pages\ListLayanans::route('/'),
            'create' => Pages\CreateLayanan::route('/create'),
            'edit' => Pages\EditLayanan::route('/{record}/edit'),
        ];
    }
}
