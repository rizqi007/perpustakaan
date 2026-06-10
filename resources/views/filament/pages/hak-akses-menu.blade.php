<x-filament-panels::page>
    <div style="display: flex; flex-direction: row; gap: 1.5rem; align-items: flex-start;">
        {{-- Left Panel: Roles --}}
        <div style="width: 300px; min-width: 300px;">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4">Level</h3>

                {{-- Add new role --}}
                <div class="mb-4">
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <input
                            type="text"
                            wire:model="newRoleName"
                            wire:keydown.enter="addRole"
                            placeholder="Nama level baru..."
                            style="flex: 1; min-width: 0; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;"
                        />
                        <button
                            wire:click="addRole"
                            style="padding: 8px 16px; background: #059669; color: white; font-size: 13px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; white-space: nowrap; display: flex; align-items: center; gap: 4px;"
                        >
                            + Tambah
                        </button>
                    </div>
                </div>

                {{-- Roles list --}}
                <div class="space-y-2">
                    @foreach($this->getRoles() as $role)
                        <div
                            wire:click="selectRole({{ $role->id }})"
                            class="flex items-center justify-between px-4 py-3 rounded-lg cursor-pointer transition-all duration-150
                                {{ $selectedRoleId === $role->id 
                                    ? 'bg-emerald-600 text-white shadow-md' 
                                    : 'bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600' }}"
                        >
                            <span class="font-semibold text-sm">
                                {{ \Illuminate\Support\Str::headline($role->name) }}
                            </span>
                            @if(!in_array($role->name, ['super_admin', 'panel_user']))
                                <button
                                    wire:click.stop="deleteRole({{ $role->id }})"
                                    class="w-6 h-6 rounded-full flex items-center justify-center
                                        {{ $selectedRoleId === $role->id 
                                            ? 'bg-red-500 hover:bg-red-600 text-white' 
                                            : 'bg-red-100 hover:bg-red-200 text-red-600' }} transition"
                                    title="Hapus"
                                >
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Panel: Permissions Table --}}
        <div style="flex: 1; min-width: 0;">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                @if($selectedRoleId)
                    @php $selectedRole = $this->getSelectedRole(); @endphp
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-emerald-700 dark:text-emerald-400">
                            {{ $selectedRole ? \Illuminate\Support\Str::headline($selectedRole->name) : '' }}
                        </h3>
                        <button
                            wire:click="savePermissions"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg transition shadow-sm"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan
                        </button>
                    </div>

                    {{-- Permissions Table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-left py-3 px-2 font-bold text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wider">Menu</th>
                                    <th class="text-center py-3 px-2 font-bold text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wider">Cek Semua</th>
                                    <th class="text-center py-3 px-2 font-bold text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wider">Baca</th>
                                    <th class="text-center py-3 px-2 font-bold text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wider">Tambah</th>
                                    <th class="text-center py-3 px-2 font-bold text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wider">Perbarui</th>
                                    <th class="text-center py-3 px-2 font-bold text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wider">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($this->getGroupedPermissions() as $group => $perms)
                                    <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                        <td class="py-3 px-2 font-semibold text-gray-800 dark:text-gray-200">{{ $group }}</td>
                                        
                                        {{-- Cek Semua (view_any) --}}
                                        <td class="text-center py-3 px-2">
                                            @php $viewAny = collect($perms)->firstWhere('prefix', 'view_any'); @endphp
                                            @if($viewAny)
                                                <input type="checkbox" wire:model.live="permissions.{{ $viewAny['name'] }}" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer" />
                                            @else
                                                <span class="text-gray-300">—</span>
                                            @endif
                                        </td>
                                        
                                        {{-- Baca (view) --}}
                                        <td class="text-center py-3 px-2">
                                            @php $view = collect($perms)->firstWhere('prefix', 'view'); @endphp
                                            @if($view)
                                                <input type="checkbox" wire:model.live="permissions.{{ $view['name'] }}" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer" />
                                            @else
                                                <span class="text-gray-300">—</span>
                                            @endif
                                        </td>
                                        
                                        {{-- Tambah (create) --}}
                                        <td class="text-center py-3 px-2">
                                            @php $create = collect($perms)->firstWhere('prefix', 'create'); @endphp
                                            @if($create)
                                                <input type="checkbox" wire:model.live="permissions.{{ $create['name'] }}" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer" />
                                            @else
                                                <span class="text-gray-300">—</span>
                                            @endif
                                        </td>
                                        
                                        {{-- Perbarui (update) --}}
                                        <td class="text-center py-3 px-2">
                                            @php $update = collect($perms)->firstWhere('prefix', 'update'); @endphp
                                            @if($update)
                                                <input type="checkbox" wire:model.live="permissions.{{ $update['name'] }}" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer" />
                                            @else
                                                <span class="text-gray-300">—</span>
                                            @endif
                                        </td>
                                        
                                        {{-- Hapus (delete) --}}
                                        <td class="text-center py-3 px-2">
                                            @php $delete = collect($perms)->firstWhere('prefix', 'delete'); @endphp
                                            @if($delete)
                                                <input type="checkbox" wire:model.live="permissions.{{ $delete['name'] }}" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer" />
                                            @else
                                                <span class="text-gray-300">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12 text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <p class="text-sm">Pilih peran untuk mengatur hak akses</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
