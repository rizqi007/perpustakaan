<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Header Action --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Database: <span class="font-mono font-semibold text-primary-600 dark:text-primary-400">{{ config('database.connections.mysql.database') }}</span>
                    &bull; Server: <span class="font-mono text-primary-600 dark:text-primary-400">{{ config('database.connections.mysql.host') }}</span>
                </p>
            </div>
            <x-filament::button
                wire:click="createBackup"
                wire:loading.attr="disabled"
                wire:target="createBackup"
                icon="heroicon-o-plus-circle"
                size="lg"
            >
                <span wire:loading.remove wire:target="createBackup">Buat Cadangan Baru</span>
                <span wire:loading wire:target="createBackup">
                    <svg class="inline w-4 h-4 animate-spin mr-1" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Membuat Cadangan...
                </span>
            </x-filament::button>
        </div>

        {{-- Info --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-primary-500"/>
                    Informasi
                </div>
            </x-slot>
            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                <p>• Pencadangan menggunakan <code class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 rounded text-xs font-mono">mysqldump</code> untuk membuat salinan lengkap database dalam format <code class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 rounded text-xs font-mono">.sql</code>.</p>
                <p>• Disarankan untuk membuat cadangan secara rutin, terutama sebelum melakukan perubahan besar pada data.</p>
                <p>• Berkas cadangan disimpan di server dan dapat diunduh kapan saja.</p>
            </div>
        </x-filament::section>

        {{-- Backup List --}}
        @php $backups = $this->getBackups(); @endphp

        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-clock class="w-5 h-5 text-gray-400"/>
                        Riwayat Cadangan
                    </div>
                    <span class="text-xs font-normal text-gray-400">{{ count($backups) }} berkas</span>
                </div>
            </x-slot>

            @if(count($backups) > 0)
                <div class="overflow-x-auto -mx-6 -mb-6">
                    <table class="w-full text-sm">
                        <thead>
                           <tr class="bg-gray-50 dark:bg-white/5 border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Berkas</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ukuran</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($backups as $backup)
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors" wire:key="backup-{{ $backup['name'] }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="shrink-0 p-2 bg-primary-50 dark:bg-primary-500/10 rounded-lg">
                                                <x-heroicon-o-circle-stack class="w-5 h-5 text-primary-500"/>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $backup['name'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 text-xs font-semibold rounded-md">
                                            {{ $backup['size'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400 text-sm">
                                        {{ $backup['created_at'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <x-filament::button
                                                wire:click="downloadBackup('{{ $backup['name'] }}')"
                                                size="sm"
                                                color="success"
                                                icon="heroicon-o-arrow-down-tray"
                                                outlined
                                            >
                                                Unduh
                                            </x-filament::button>

                                            <x-filament::button
                                                size="sm"
                                                color="danger"
                                                icon="heroicon-o-trash"
                                                outlined
                                                wire:click="mountAction('deleteBackup', { name: '{{ $backup['name'] }}' })"
                                            >
                                                Hapus
                                            </x-filament::button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto w-14 h-14 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <x-heroicon-o-circle-stack class="w-7 h-7 text-gray-400"/>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada cadangan database.</p>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Klik "Buat Cadangan Baru" untuk memulai.</p>
                </div>
            @endif
        </x-filament::section>

    </div>
</x-filament-panels::page>
