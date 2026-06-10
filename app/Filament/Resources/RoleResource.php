<?php

namespace App\Filament\Resources;

use BezhanSalleh\FilamentShield\Resources\RoleResource as ShieldRoleResource;
use App\Filament\Resources\RoleResource\Pages;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class RoleResource extends ShieldRoleResource
{
    protected static ?string $navigationGroup = 'Pelindung';

    protected static ?string $navigationLabel = 'Peran';

    protected static ?string $modelLabel = 'Peran';

    protected static ?string $pluralModelLabel = 'Peran';

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?int $navigationSort = -1;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        return strval(static::getEloquentQuery()->count());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->weight('bold')
                    ->label('Nama Peran')
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('permissions_count')
                    ->badge()
                    ->label('Jumlah Izin')
                    ->counts('permissions')
                    ->color('success'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('Lihat'),
                    Tables\Actions\EditAction::make()
                        ->label('Ubah'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'view' => Pages\ViewRole::route('/{record}'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
