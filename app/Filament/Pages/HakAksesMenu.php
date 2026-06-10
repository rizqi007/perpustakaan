<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class HakAksesMenu extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Hak Akses Menu';

    protected static ?string $title = 'Hak Akses Menu';

    protected static ?string $navigationGroup = 'Pelindung';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.pages.hak-akses-menu';

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    public ?int $selectedRoleId = null;
    public string $newRoleName = '';
    public array $permissions = [];

    public function mount(): void
    {
        $firstRole = Role::first();
        if ($firstRole) {
            $this->selectedRoleId = $firstRole->id;
            $this->loadPermissions();
        }
    }

    public function selectRole(int $roleId): void
    {
        $this->selectedRoleId = $roleId;
        $this->loadPermissions();
    }

    public function loadPermissions(): void
    {
        if (!$this->selectedRoleId) return;

        $role = Role::find($this->selectedRoleId);
        if (!$role) return;

        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $this->permissions = [];

        foreach ($this->getGroupedPermissions() as $group => $perms) {
            foreach ($perms as $perm) {
                $this->permissions[$perm['name']] = in_array($perm['name'], $rolePermissions);
            }
        }
    }

    public function addRole(): void
    {
        if (empty(trim($this->newRoleName))) return;

        $role = Role::create([
            'name' => Str::slug($this->newRoleName, '_'),
            'guard_name' => 'web',
        ]);

        $this->selectedRoleId = $role->id;
        $this->newRoleName = '';
        $this->loadPermissions();

        Notification::make()
            ->title('Peran berhasil ditambahkan')
            ->success()
            ->send();
    }

    public function deleteRole(int $roleId): void
    {
        $role = Role::find($roleId);
        if ($role && !in_array($role->name, ['super_admin', 'panel_user'])) {
            $role->delete();

            if ($this->selectedRoleId === $roleId) {
                $firstRole = Role::first();
                $this->selectedRoleId = $firstRole?->id;
                $this->loadPermissions();
            }

            Notification::make()
                ->title('Peran berhasil dihapus')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Peran bawaan tidak bisa dihapus')
                ->danger()
                ->send();
        }
    }

    public function savePermissions(): void
    {
        if (!$this->selectedRoleId) return;

        $role = Role::find($this->selectedRoleId);
        if (!$role) return;

        $enabledPermissions = array_keys(array_filter($this->permissions));
        $role->syncPermissions($enabledPermissions);

        Notification::make()
            ->title('Hak akses berhasil disimpan')
            ->success()
            ->send();
    }

    public function toggleAll(string $group, bool $value): void
    {
        $perms = $this->getGroupedPermissions()[$group] ?? [];
        foreach ($perms as $perm) {
            $this->permissions[$perm['name']] = $value;
        }
    }

    public function toggleColumnAll(string $prefix, bool $value): void
    {
        foreach ($this->permissions as $key => $val) {
            if (Str::startsWith($key, $prefix . '_')) {
                $this->permissions[$key] = $value;
            }
        }
    }

    public function getGroupedPermissions(): array
    {
        $allPermissions = Permission::where('guard_name', 'web')->get();
        $prefixes = ['view_any', 'view', 'create', 'update', 'delete_any', 'delete', 'restore_any', 'restore', 'replicate', 'reorder', 'force_delete_any', 'force_delete', 'page', 'widget'];
        $grouped = [];

        foreach ($allPermissions as $permission) {
            $name = $permission->name;
            $matchedPrefix = 'other';
            $resource = $name;

            // Find matching prefix (longest first)
            $sortedPrefixes = $prefixes;
            usort($sortedPrefixes, fn($a, $b) => strlen($b) - strlen($a));

            foreach ($sortedPrefixes as $prefix) {
                if (Str::startsWith($name, $prefix . '_')) {
                    $matchedPrefix = $prefix;
                    $resource = Str::after($name, $prefix . '_');
                    break;
                }
            }

            $group = Str::headline(str_replace('::', ' ', $resource));
            
            $grouped[$group][] = [
                'name' => $name,
                'prefix' => $matchedPrefix,
                'label' => Str::headline($matchedPrefix),
            ];
        }

        ksort($grouped);
        return $grouped;
    }

    public function getPrefixes(): array
    {
        return ['view', 'view_any', 'create', 'update', 'delete'];
    }

    public function getPrefixLabels(): array
    {
        return [
            'view' => 'Baca',
            'view_any' => 'Cek Semua',
            'create' => 'Tambah',
            'update' => 'Perbarui',
            'delete' => 'Hapus',
        ];
    }

    public function getRoles()
    {
        return Role::all();
    }

    public function getSelectedRole(): ?Role
    {
        return $this->selectedRoleId ? Role::find($this->selectedRoleId) : null;
    }
}
