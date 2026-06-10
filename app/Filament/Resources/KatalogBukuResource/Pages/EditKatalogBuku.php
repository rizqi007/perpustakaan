<?php

namespace App\Filament\Resources\KatalogBukuResource\Pages;

use App\Filament\Resources\KatalogBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKatalogBuku extends EditRecord
{
    protected static string $resource = KatalogBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
