<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Berita & Artikel</h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Dapatkan informasi terbaru seputar perpustakaan dan kegiatan literasi terkini.</p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-xl mx-auto mb-12">
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari berita..." class="w-full pl-10 pr-4 py-3 rounded-full border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-800 dark:text-white shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        @if($beritas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($beritas as $berita)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
                        <a href="{{ route('berita.show', $berita->slug ?? $berita->id) }}" class="block relative h-48 overflow-hidden">
                            @if($berita->image)
                                <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                </div>
                            @endif
                        </a>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="text-sm text-emerald-600 dark:text-emerald-400 font-semibold mb-2">
                                {{ $berita->created_at->translatedFormat('d M Y') }}
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                <a href="{{ route('berita.show', $berita->slug ?? $berita->id) }}" class="hover:text-emerald-600 transition-colors">
                                    {{ $berita->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 line-clamp-3 mb-4 flex-1">
                                {{ Str::limit(strip_tags($berita->content), 120) }}
                            </p>
                            <a href="{{ route('berita.show', $berita->slug ?? $berita->id) }}" class="inline-flex items-center text-emerald-600 dark:text-emerald-400 font-medium hover:underline mt-auto">
                                Baca Selengkapnya <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $beritas->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Tidak ada berita</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada berita yang diterbitkan saat ini.</p>
            </div>
        @endif
    </div>
</div>
