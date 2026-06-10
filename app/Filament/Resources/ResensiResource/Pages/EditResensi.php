<?php

namespace App\Filament\Resources\ResensiResource\Pages;

use App\Filament\Resources\ResensiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResensi extends EditRecord
{
    protected static string $resource = ResensiResource::class;

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
