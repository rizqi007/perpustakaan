<?php

namespace App\Filament\Resources\ProfilBalaiResource\Pages;

use App\Filament\Resources\ProfilBalaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilBalais extends ListRecords
{
    protected static string $resource = ProfilBalaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
