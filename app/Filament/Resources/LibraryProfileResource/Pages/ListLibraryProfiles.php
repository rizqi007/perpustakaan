<?php

namespace App\Filament\Resources\LibraryProfileResource\Pages;

use App\Filament\Resources\LibraryProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLibraryProfiles extends ListRecords
{
    protected static string $resource = LibraryProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
