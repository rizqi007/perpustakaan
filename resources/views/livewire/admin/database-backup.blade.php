<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="p-2.5 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                        </svg>
                    </div>
                    Backup Database
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 ml-16">
                    Kelola backup database <span class="font-mono text-indigo-600 dark:text-indigo-400">{{ $dbName }}</span>
                    pada server <span class="font-mono text-indigo-600 dark:text-indigo-400">{{ $dbHost }}</span>
                </p>
            </div>

            {{-- Create Backup Button --}}
            <button
                wire:click="createBackup"
                wire:loading.attr="disabled"
                wire:target="createBackup"
                class="inline-flex items-center gap-2.5 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold text-sm rounded-xl transition-all duration-300 shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 disabled:opacity-60 disabled:cursor-not-allowed transform hover:scale-[1.02] active:scale-[0.98]"
            >
                <span wire:loading.remove wire:target="createBackup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </span>
                <span wire:loading wire:target="createBackup">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </span>
                <span wire:loading.remove wire:target="createBackup">Buat Backup Baru</span>
                <span wire:loading wire:target="createBackup">Membuat Backup...</span>
            </button>
        </div>

        {{-- Alert Messages --}}
        @if($backupMessage)
            <div @class([
                'px-5 py-4 rounded-xl mb-6 flex items-start gap-3 border shadow-sm animate-fade-in',
                'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300' => $backupMessageType === 'success',
                'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-800 dark:text-red-300' => $backupMessageType === 'error',
            ])>
                @if($backupMessageType === 'success')
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @endif
                <span class="text-sm font-medium">{{ $backupMessage }}</span>
            </div>
        @endif

        {{-- Info Card --}}
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-5 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-sm text-blue-800 dark:text-blue-300">
                    <p class="font-semibold mb-1">Informasi Backup</p>
                    <ul class="list-disc list-inside space-y-0.5 text-blue-700 dark:text-blue-400">
                        <li>Backup menggunakan <code class="bg-blue-100 dark:bg-blue-800/50 px-1.5 py-0.5 rounded text-xs font-mono">mysqldump</code> untuk membuat salinan lengkap database.</li>
                        <li>File backup disimpan di server dalam format <code class="bg-blue-100 dark:bg-blue-800/50 px-1.5 py-0.5 rounded text-xs font-mono">.sql</code>.</li>
                        <li>Disarankan untuk membuat backup secara rutin, terutama sebelum melakukan perubahan besar.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Backups Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Backup</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ count($backups) }} file backup tersedia</p>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Terurut dari terbaru
                </div>
            </div>

            @if(count($backups) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama File</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ukuran</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Dibuat</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($backups as $backup)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-indigo-100 dark:bg-indigo-900/40 rounded-lg">
                                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $backup['name'] }}</p>
                                                <p class="text-xs text-gray-400 font-mono">.sql</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-lg">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            {{ $backup['size'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $backup['created_at'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- Download --}}
                                            <button
                                                wire:click="downloadBackup('{{ $backup['name'] }}')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 text-xs font-semibold rounded-lg transition-colors"
                                                title="Download backup"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                                Download
                                            </button>
                                            {{-- Delete --}}
                                            <button
                                                wire:click="confirmDelete('{{ $backup['name'] }}')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 text-xs font-semibold rounded-lg transition-colors"
                                                title="Hapus backup"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-16 text-center">
                    <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-base font-medium">Belum ada backup database.</p>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Klik tombol "Buat Backup Baru" untuk membuat backup pertama.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" wire:click.self="cancelDelete">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 p-0 overflow-hidden transform transition-all">
                {{-- Modal Header --}}
                <div class="bg-red-50 dark:bg-red-900/30 px-6 py-5 flex items-center gap-3">
                    <div class="p-2 bg-red-100 dark:bg-red-800/50 rounded-full">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-red-800 dark:text-red-300">Konfirmasi Hapus</h3>
                        <p class="text-xs text-red-600 dark:text-red-400">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="px-6 py-5">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Apakah Anda yakin ingin menghapus file backup berikut?
                    </p>
                    <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <p class="text-sm font-mono font-medium text-gray-900 dark:text-white break-all">{{ $deleteFileName }}</p>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex items-center justify-end gap-3">
                    <button
                        wire:click="cancelDelete"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-500 border border-gray-300 dark:border-gray-500 rounded-lg transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        wire:click="deleteBackup"
                        class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors shadow-sm"
                    >
                        Ya, Hapus Backup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
