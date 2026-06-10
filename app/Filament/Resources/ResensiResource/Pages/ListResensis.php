<?php

namespace App\Filament\Resources\ResensiResource\Pages;

use App\Filament\Resources\ResensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResensis extends ListRecords
{
    protected static string $resource = ResensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
