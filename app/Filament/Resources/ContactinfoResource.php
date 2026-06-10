<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactinfoResource\Pages;
use App\Filament\Resources\ContactinfoResource\RelationManagers;
use App\Models\ContactInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactinfoResource extends Resource
{
    protected static ?string $model = Contactinfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Informasi Kontak';

    protected static ?string $modelLabel = 'Informasi Kontak';

    protected static ?string $pluralModelLabel = 'Informasi Kontak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('monday_thursday')
                    ->required()
                    ->maxLength(255)
                    ->default('07:00 - 16:00'),
                Forms\Components\TextInput::make('friday')
                    ->required()
                    ->maxLength(255)
                    ->default('07:00 - 16:30'),
                Forms\Components\TextInput::make('saturday')
                    ->required()
                    ->maxLength(255)
                    ->default('Tutup'),
                Forms\Components\TextInput::make('sunday')
                    ->required()
                    ->maxLength(255)
                    ->default('Tutup'),
                Forms\Components\Textarea::make('map_embed_url')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('map_latitude')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('map_longitude')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('monday_thursday')
                    ->searchable(),
                Tables\Columns\TextColumn::make('friday')
                    ->searchable(),
                Tables\Columns\TextColumn::make('saturday')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sunday')
                    ->searchable(),
                Tables\Columns\TextColumn::make('map_latitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('map_longitude')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
                ])
                ->icon('heroicon-m-ellipsis-vertical')
                ->tooltip('Aksi'),
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
            'index' => Pages\ListContactinfos::route('/'),
            'create' => Pages\CreateContactinfo::route('/create'),
            'edit' => Pages\EditContactinfo::route('/{record}/edit'),
        ];
    }
}
