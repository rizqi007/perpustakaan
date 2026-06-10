<?php

namespace App\Filament\Resources\KlipingDigitalResource\Pages;

use App\Filament\Resources\KlipingDigitalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKlipingDigital extends CreateRecord
{
    protected static string $resource = KlipingDigitalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
