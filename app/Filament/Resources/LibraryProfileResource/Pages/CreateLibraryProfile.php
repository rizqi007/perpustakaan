<?php

namespace App\Filament\Resources\LibraryProfileResource\Pages;

use App\Filament\Resources\LibraryProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLibraryProfile extends CreateRecord
{
    protected static string $resource = LibraryProfileResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
