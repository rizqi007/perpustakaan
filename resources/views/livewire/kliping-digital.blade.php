<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Kliping Digital</h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-4">
                Kliping berita dari berbagai surat kabar terkait Kementerian Agama dan keislaman.
            </p>
            <a href="https://bit.ly/kliping-digital" target="_blank" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-full transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                bit.ly/kliping-digital
            </a>
        </div>

        <div class="mb-8 max-w-4xl mx-auto">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Search Input -->
                <div class="relative flex-grow">
                    <input wire:model.live.debounce.300ms="search" 
                           type="text" 
                           placeholder="Cari judul, penulis, atau topik..." 
                           class="w-full px-5 py-3 rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent shadow-sm transition-all pl-12">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Year Filter -->
                <div class="w-full md:w-40 flex-shrink-0 relative z-30" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" type="button" class="w-full px-5 py-3 text-left rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white hover:border-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:border-transparent shadow-sm transition-all flex items-center justify-between group">
                        <span class="truncate font-medium">{{ $selectedYear ?: 'Tahun' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-emerald-500 transition-colors transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute z-50 mt-2 w-full bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 py-2 max-h-60 overflow-y-auto"
                         style="display: none;">
                        
                        <button type="button" wire:click="setYear('')" class="w-full text-left px-4 py-2.5 text-sm transition-colors block {{ $selectedYear === '' ? 'bg-emerald-600 text-white font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                            Semua Tahun
                        </button>
                        
                        @foreach($years as $year)
                            <button type="button" wire:key="year-{{ $year }}" wire:click="setYear('{{ $year }}')" class="w-full text-left px-4 py-2.5 text-sm transition-colors block {{ $selectedYear == $year ? 'bg-emerald-600 text-white font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                                {{ $year }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Source Filter -->
                <div class="w-full md:w-56 flex-shrink-0 relative z-30" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" type="button" class="w-full px-5 py-3 text-left rounded-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white hover:border-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:border-transparent shadow-sm transition-all flex items-center justify-between group">
                        <span class="truncate font-medium">{{ $selectedSource ?: 'Semua Media' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-emerald-500 transition-colors transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute z-50 mt-2 w-full bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 py-2 max-h-60 overflow-y-auto"
                         style="display: none;">
                        
                        <button type="button" wire:click="setSource('')" class="w-full text-left px-4 py-2.5 text-sm transition-colors block {{ $selectedSource === '' ? 'bg-emerald-600 text-white font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                            Semua Media
                        </button>
                        
                        @foreach($sources as $source)
                            <button type="button" wire:key="source-{{ md5($source) }}" wire:click="setSource('{{ addslashes($source) }}')" class="w-full text-left px-4 py-2.5 text-sm transition-colors block {{ $selectedSource == $source ? 'bg-emerald-600 text-white font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                                {{ $source }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Judul Artikel</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penulis</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Media & Rubrik</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Hal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($klipings as $kliping)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $kliping->published_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        @if($kliping->url)
                                            <a href="{{ $kliping->url }}" target="_blank" class="hover:text-emerald-600 transition flex items-center gap-1">
                                                {{ $kliping->title }}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        @else
                                            {{ $kliping->title }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    {{ $kliping->author }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $kliping->source }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $kliping->topic }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-right">
                                    {{ $kliping->page_number }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                        <p>Tidak ada data kliping ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
             @if($klipings->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    {{ $klipings->links('vendor.pagination.kliping') }}
                </div>
            @endif
        </div>
    </div>
</div>
