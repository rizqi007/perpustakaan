<?php

namespace App\Filament\Resources\TempatSampahResource\Pages;

use App\Filament\Resources\TempatSampahResource;
use Filament\Resources\Pages\ListRecords;

class ListTempatSampahs extends ListRecords
{
    protected static string $resource = TempatSampahResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
