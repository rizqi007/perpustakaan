<?php

namespace App\Filament\Resources\KatalogBukuResource\Pages;

use App\Filament\Resources\KatalogBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKatalogBuku extends CreateRecord
{
    protected static string $resource = KatalogBukuResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
