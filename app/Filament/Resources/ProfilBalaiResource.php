<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilBalaiResource\Pages;
use App\Filament\Resources\ProfilBalaiResource\RelationManagers;
use App\Models\ProfilBalai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfilBalaiResource extends Resource
{
    protected static ?string $model = ProfilBalai::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    
    protected static ?string $navigationLabel = 'Profil Perpustakaan Balai';

    protected static ?string $modelLabel = 'Profil Perpustakaan Balai';

    protected static ?string $navigationGroup = 'Tentang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('Gambar Balai')
                    ->image()
                    ->directory('profil-balai')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nama_balai')
                    ->label('Nama Balai')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state)))
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                \AmidEsfahani\FilamentTinyEditor\TinyEditor::make('description')
                    ->label('Penjelasan / Profil')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('author')
                    ->label('Pembuat Tulisan (Author)')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar'),
                Tables\Columns\TextColumn::make('nama_balai')
                    ->label('Nama Balai')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author')
                    ->label('Author')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfilBalais::route('/'),
            'create' => Pages\CreateProfilBalai::route('/create'),
            'edit' => Pages\EditProfilBalai::route('/{record}/edit'),
        ];
    }
}
