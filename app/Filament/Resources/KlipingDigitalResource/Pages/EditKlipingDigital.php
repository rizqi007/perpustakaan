<?php

namespace App\Filament\Resources\KlipingDigitalResource\Pages;

use App\Filament\Resources\KlipingDigitalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKlipingDigital extends EditRecord
{
    protected static string $resource = KlipingDigitalResource::class;

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
