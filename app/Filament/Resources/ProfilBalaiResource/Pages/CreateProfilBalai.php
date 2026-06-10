<?php

namespace App\Filament\Resources\ProfilBalaiResource\Pages;

use App\Filament\Resources\ProfilBalaiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProfilBalai extends CreateRecord
{
    protected static string $resource = ProfilBalaiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
