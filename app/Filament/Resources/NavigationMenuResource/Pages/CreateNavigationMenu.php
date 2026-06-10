<?php

namespace App\Filament\Resources\NavigationMenuResource\Pages;

use App\Filament\Resources\NavigationMenuResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateNavigationMenu extends CreateRecord
{
    protected static string $resource = NavigationMenuResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        Cache::forget('navigation_menus');
    }
}
