<?php

namespace App\Filament\Resources\CardTemplateResource\Pages;

use App\Filament\Resources\CardTemplateResource;
use App\Models\CardTemplate;
use Filament\Resources\Pages\CreateRecord;

class CreateCardTemplate extends CreateRecord
{
    protected static string $resource = CardTemplateResource::class;

    protected function afterCreate(): void
    {
        // If this template is set as active, deactivate others
        if ($this->record->is_active) {
            CardTemplate::where('id', '!=', $this->record->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
