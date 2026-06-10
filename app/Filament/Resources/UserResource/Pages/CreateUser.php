<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract role to set it separately after creation
        $this->roleToAssign = $data['role'] ?? 'user';
        unset($data['role']);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Set role via forceFill since it's not mass-assignable
        if (isset($this->roleToAssign)) {
            $this->record->forceFill(['role' => $this->roleToAssign])->save();
        }
    }

    protected string $roleToAssign = 'user';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
