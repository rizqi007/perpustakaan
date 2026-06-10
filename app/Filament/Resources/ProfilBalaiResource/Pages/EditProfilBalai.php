<?php

namespace App\Filament\Resources\ProfilBalaiResource\Pages;

use App\Filament\Resources\ProfilBalaiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfilBalai extends EditRecord
{
    protected static string $resource = ProfilBalaiResource::class;

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
