<div class="pt-11 pb-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">Profil Perpustakaan Balai</h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Menjelajahi profil dan sejarah perpustakaan di lingkungan balai.</p>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($profils as $item)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col h-full">
                    @if($item->image)
                        <div class="h-48 w-full overflow-hidden">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->nama_balai }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                        </div>
                    @else
                        <div class="h-48 w-full bg-emerald-600 flex items-center justify-center">
                            <svg class="h-16 w-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="p-6 flex-1 flex flex-col">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                            <a href="{{ route('tentang.profil-balai.show', $item->slug) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                                {{ $item->nama_balai }}
                            </a>
                        </h2>
                        
                        <div class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3 flex-1 prose dark:prose-invert">
                            {!! Str::limit(strip_tags($item->description), 150) !!}
                        </div>

                        <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            @if($item->author)
                                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $item->author }}
                                </span>
                            @else
                                <span></span>
                            @endif

                            <a href="{{ route('tentang.profil-balai.show', $item->slug) }}" class="inline-flex items-center text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                                Selengkapnya
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Belum ada profil balai</h3>
                    <p class="mt-1 text-gray-500 dark:text-gray-400">Silakan tambahkan data melalui panel admin.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
