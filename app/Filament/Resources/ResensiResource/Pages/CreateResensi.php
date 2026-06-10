<?php

namespace App\Filament\Resources\ResensiResource\Pages;

use App\Filament\Resources\ResensiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateResensi extends CreateRecord
{
    protected static string $resource = ResensiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
