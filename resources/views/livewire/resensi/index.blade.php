<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Koleksi Ulasan</span>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Ulasan Buku Terkini</h1>
            <div class="w-24 h-1.5 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                Temukan referensi bacaan terbaik melalui ulasan mendalam dari komunitas perpustakaan kami.
            </p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($resensis as $resensi)
                <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 flex flex-col h-full group">
                    <div class="relative overflow-hidden h-64">
                        <img src="{{ asset('storage/' . $resensi->cover_image) }}" 
                             alt="{{ $resensi->book_title }}" 
                             class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-4 right-4 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                             <span class="text-white text-sm font-medium bg-emerald-600 px-3 py-1 rounded-full shadow-lg">
                                {{ $resensi->published_at ? $resensi->published_at->translatedFormat('d M Y') : $resensi->created_at->translatedFormat('d M Y') }}
                             </span>
                        </div>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-gray-900 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                                <a href="{{ route('resensi.show', $resensi->slug) }}">
                                    {{ $resensi->title }}
                                </a>
                            </h3>
                            <p class="text-emerald-600 font-semibold mt-1 text-sm">{{ $resensi->book_title }}</p>
                            <p class="text-xs text-gray-500 mt-1">Oleh: {{ $resensi->reviewer_name }}</p>
                        </div>

                        <div class="text-gray-600 text-sm line-clamp-3 mb-6 flex-1">
                            {!! Str::limit(strip_tags($resensi->cleaned_content), 150) !!}
                        </div>

                        <a href="{{ route('resensi.show', $resensi->slug) }}" class="inline-flex items-center text-emerald-600 font-semibold text-sm hover:underline mt-auto">
                            Baca Selengkapnya <svg class="w-3 h-3 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-1 md:col-span-3 text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada ulasan</h3>
                    <p class="text-gray-500">Saat ini belum ada resensi buku yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $resensis->links() }}
        </div>
    </div>
</div>
