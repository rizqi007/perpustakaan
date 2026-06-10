<x-filament-panels::page>
    {{ $this->table }}
    
    @if($isSyncing)
        <!-- Beautiful Glassmorphic Progress Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity duration-300">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-800 border border-gray-100 dark:border-gray-700 transform scale-100 transition-transform duration-300">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2 bg-amber-50 text-amber-600 rounded-lg dark:bg-amber-950/30 dark:text-amber-400">
                        <svg class="h-6 w-6 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sinkronisasi Google Sheet</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Sedang memproses data dari Google Sheet...</p>
                    </div>
                </div>

                <!-- Progress percentage -->
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/30 px-2.5 py-0.5 rounded-full">
                        {{ $processedRows }} / {{ $totalRows }} Baris
                    </span>
                    <span class="font-bold text-gray-900 dark:text-white text-base">
                        {{ $syncPercentage }}%
                    </span>
                </div>

                <!-- Beautiful animated progress bar container -->
                <div class="h-3 w-full bg-gray-100 rounded-full overflow-hidden dark:bg-gray-700">
                    <div class="h-full bg-amber-500 rounded-full transition-all duration-300 ease-out" 
                         style="width: {{ $syncPercentage }}%">
                    </div>
                </div>

                <div class="mt-4 text-[11px] text-gray-400 dark:text-gray-500 text-center leading-relaxed">
                    Mohon jangan menutup halaman ini sampai proses sinkronisasi selesai.
                </div>
            </div>
        </div>
        
        <!-- Livewire Polling to call importNextChunk every 500ms (optimized for database safety) -->
        <div wire:poll.500ms="importNextChunk"></div>
    @endif
</x-filament-panels::page>
