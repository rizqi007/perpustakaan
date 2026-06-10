<?php

namespace App\Filament\Resources\CardTemplateResource\Pages;

use App\Filament\Resources\CardTemplateResource;
use App\Models\CardTemplate;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardTemplate extends EditRecord
{
    protected static string $resource = CardTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
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
