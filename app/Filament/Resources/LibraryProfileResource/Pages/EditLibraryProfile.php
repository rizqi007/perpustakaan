<?php

namespace App\Filament\Resources\LibraryProfileResource\Pages;

use App\Filament\Resources\LibraryProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLibraryProfile extends EditRecord
{
    protected static string $resource = LibraryProfileResource::class;

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
