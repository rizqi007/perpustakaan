<x-filament-panels::page>
    <form wire:submit="saveSettings" class="space-y-6">
        {{ $this->form }}

        <div class="flex flex-wrap items-center gap-3">
            <x-filament::button type="submit" size="md">
                Simpan Konfigurasi
            </x-filament::button>

            <x-filament::button type="button" color="gray" size="md" wire:click="testConnection" wire:loading.attr="disabled" wire:target="testConnection">
                <span wire:loading.remove wire:target="testConnection">Cek Koneksi</span>
                <span wire:loading wire:target="testConnection">Menghubungkan...</span>
            </x-filament::button>
        </div>
    </form>

    {{-- Status Koneksi Card --}}
    <div class="mt-6">
        <x-filament::section>
            <x-slot name="heading">
                Status Pengujian Koneksi Terakhir
            </x-slot>

            <div class="space-y-4">
                @if ($testStatus === 'testing')
                    <div class="p-4 bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800/50 rounded-xl flex items-center gap-3">
                        <svg class="w-6 h-6 animate-spin text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800 dark:text-blue-300">Menghubungkan...</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">Sedang memverifikasi handshake ke database SLiMS.</p>
                        </div>
                    </div>
                @elseif ($testStatus === 'success')
                    <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl flex items-start gap-3">
                        <x-heroicon-o-check-circle class="w-6 h-6 text-emerald-500 shrink-0 mt-0.5" />
                        <div>
                            <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">Koneksi Berhasil</p>
                            <p class="text-xs text-emerald-600 dark:text-emerald-400">{{ $testMessage }}</p>
                        </div>
                    </div>
                @elseif ($testStatus === 'failed')
                    <div class="p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/50 rounded-xl flex items-start gap-3">
                        <x-heroicon-o-x-circle class="w-6 h-6 text-red-500 shrink-0 mt-0.5" />
                        <div>
                            <p class="text-sm font-semibold text-red-800 dark:text-red-300">Koneksi Gagal</p>
                            <p class="text-xs text-red-600 dark:text-red-400 overflow-hidden text-ellipsis">{{ $testMessage }}</p>
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl flex items-start gap-3">
                        <x-heroicon-o-information-circle class="w-6 h-6 text-gray-500 dark:text-gray-400 shrink-0 mt-0.5" />
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum Ada Pengujian</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Klik "Cek Koneksi" di atas untuk menguji kredensial database sebelum disimpan.</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-xs text-gray-500 dark:text-gray-400 space-y-2 pt-4 border-t border-gray-100 dark:border-gray-800 mt-4">
                <p class="font-semibold text-gray-700 dark:text-gray-300">💡 Petunjuk Koneksi SLiMS:</p>
                <ul class="list-disc list-inside space-y-1 pl-1">
                    <li>Koneksi database menggunakan driver MySQL.</li>
                    <li>Gunakan host <code class="bg-gray-100 dark:bg-gray-800 px-1 py-0.5 rounded text-xs">127.0.0.1</code> jika server database berada di mesin yang sama dengan aplikasi web.</li>
                    <li>Perubahan ini akan langsung disimpan dan memperbarui berkas <code class="bg-gray-100 dark:bg-gray-800 px-1 py-0.5 rounded text-xs">.env</code> secara otomatis.</li>
                </ul>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
