<?php

namespace App\Filament\Resources\DaftarHadirResource\Pages;

use App\Filament\Resources\DaftarHadirResource;
use Filament\Resources\Pages\EditRecord;

class EditDaftarHadir extends EditRecord
{
    protected static string $resource = DaftarHadirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
