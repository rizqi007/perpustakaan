<?php

namespace App\Filament\Resources\KatalogBukuResource\Pages;

use App\Filament\Resources\KatalogBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKatalogBukus extends ListRecords
{
    protected static string $resource = KatalogBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
