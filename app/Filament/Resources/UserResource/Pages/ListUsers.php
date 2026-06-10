<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->label('Semua'),
            'pending' => Tab::make('Belum Validasi')
                ->label('Belum Validasi')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_validated', false))
                ->badge(\App\Models\User::where('is_validated', false)->count())
                ->badgeColor('warning'),
            'validated' => Tab::make('Sudah Validasi')
                ->label('Sudah Validasi')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_validated', true))
                ->badge(\App\Models\User::where('is_validated', true)->count())
                ->badgeColor('success'),
        ];
    }
}
