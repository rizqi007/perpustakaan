<?php

namespace App\Filament\Resources\NavigationMenuResource\Pages;

use App\Filament\Resources\NavigationMenuResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Illuminate\Support\Facades\Cache;

class EditNavigationMenu extends EditRecord
{
    protected static string $resource = NavigationMenuResource::class;

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

    protected function afterSave(): void
    {
        Cache::forget('navigation_menus');
    }

    protected function afterDelete(): void
    {
        Cache::forget('navigation_menus');
    }
}
