<?php

namespace App\Filament\Resources\DaftarHadirResource\Pages;

use App\Filament\Resources\DaftarHadirResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDaftarHadir extends ListRecords
{
    protected static string $resource = DaftarHadirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Daftar Hadir Baru'),
        ];
    }
}
