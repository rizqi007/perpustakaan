<div class="min-h-screen bg-gray-50">
    {{-- Hero Section --}}
    <div class="bg-emerald-900 text-white pt-32 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-emerald-300 font-bold tracking-widest uppercase text-sm mb-2 block">Perpustakaan Kemenag RI</span>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Katalog Buku Ber-ISBN</h1>
            <div class="w-24 h-1.5 bg-emerald-400 mx-auto rounded-full mb-6"></div>
            <p class="text-gray-300 max-w-2xl mx-auto text-lg">
                Koleksi terbitan yang telah mendapatkan nomor ISBN resmi melalui layanan perpustakaan kami.
            </p>

            {{-- Search --}}
            <div class="mt-8 max-w-xl mx-auto">
                <div class="relative">
                    <input type="text"
                        wire:model.live.debounce.400ms="search"
                        placeholder="Cari judul, ISBN, subjek..."
                        class="w-full pl-12 pr-4 py-4 rounded-2xl bg-white text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-emerald-400/50 shadow-lg border border-white/20">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                        </svg>
                    </div>
                    {{-- Loading indicator --}}
                    <div wire:loading wire:target="search" class="absolute right-4 top-1/2 -translate-y-1/2">
                        <svg class="animate-spin h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('landing') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-800 font-medium">Katalog Buku</span>
        </nav>
    </div>

    {{-- Book Grid --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        @if($books->count() > 0)
            <p class="text-sm text-gray-500 mb-6">Menampilkan {{ $books->total() }} koleksi buku</p>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-8">
                @foreach($books as $book)
                    @php
                        $cover = $book->cover;
                        $isImage = $cover && preg_match('/\.(jpg|jpeg|png|webp|gif|avif)$/i', $cover);
                        $coverUrl = $cover ? asset('storage/' . $cover) : '';
                    @endphp

                    <a href="{{ route('katalog.show', $book->id) }}"
                       class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 block" style="height: 380px;">

                        {{-- Cover --}}
                        @if($isImage)
                            <img src="{{ $coverUrl }}"
                                 alt="{{ $book->judul_penanggung_jawab }}"
                                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-emerald-700 to-teal-900 flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Gradient overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>

                        {{-- Content --}}
                        <div class="absolute bottom-0 left-0 right-0 p-4 flex flex-col">
                            @if($book->identifikasi)
                                <span class="self-start inline-block px-2.5 py-0.5 bg-gray-800/80 text-white text-[10px] font-bold rounded mb-2 uppercase tracking-wide border border-white/20">
                                    {{ $book->identifikasi }}
                                </span>
                            @else
                                <span class="self-start inline-block px-2.5 py-0.5 bg-gray-800/80 text-white text-[10px] font-bold rounded mb-2 uppercase tracking-wide border border-white/20">
                                    NONE
                                </span>
                            @endif
                            <h3 class="text-white text-sm md:text-base font-bold leading-tight line-clamp-2 group-hover:text-emerald-300 transition-colors">
                                {{ Str::title($book->judul_penanggung_jawab) }}
                            </h3>
                            @if($book->publikasi)
                                <p class="text-gray-300 text-xs mt-1 line-clamp-1">{{ $book->publikasi }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $books->links() }}
            </div>

        @else
            <div class="text-center py-24">
                <svg class="w-20 h-20 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-500 mb-2">
                    @if($search)
                        Buku tidak ditemukan untuk "{{ $search }}"
                    @else
                        Belum ada koleksi katalog
                    @endif
                </h3>
                @if($search)
                    <button wire:click="$set('search','')" class="mt-4 px-6 py-2 bg-emerald-600 text-white rounded-full text-sm font-semibold hover:bg-emerald-700 transition">
                        Reset Pencarian
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>
