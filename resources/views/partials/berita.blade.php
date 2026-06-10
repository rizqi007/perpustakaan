<section id="berita" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center mb-4">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                        <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V9a1 1 0 00-1-1h-1v3a2 2 0 01-2 2H5.5a1.5 1.5 0 010-3H9V7H8a2 2 0 00-2 2v.5a1.5 1.5 0 11-3 0V9a5 5 0 015-5h7z"/>
                    </svg>
                </div>
                <div class="h-8 w-0.5 bg-green-600 mr-3"></div>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800">
                    BERITA TERKINI
                </h2>
            </div>
            <p class="text-base text-gray-700 max-w-3xl mx-auto leading-relaxed font-medium">
                Berita tentang seputar perpustakaan
            </p>
            <div class="w-16 h-1 bg-green-600 mx-auto mt-4"></div>
        </div>

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($beritas as $item)
                <article class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group flex flex-col">
                    <!-- Image Section -->
                    <a href="{{ route('berita.show', $item) }}" class="block relative overflow-hidden">
                        <div class="relative h-48 bg-gray-100">
                            <img 
                                src="{{ asset('storage/' . $item->image) }}" 
                                alt="{{ $item->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            >
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- News Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-2 py-1 bg-green-600 text-white text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    BERITA
                                </span>
                            </div>

                            <!-- Read More Icon -->
                            <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                <div class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Content Section -->
                    <div class="p-6 flex flex-col flex-grow">
                        <!-- Date -->
                        <div class="flex items-center text-xs text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <time datetime="{{ $item->published_at->format('Y-m-d') }}">
                                {{ $item->published_at->format('d F Y') }}
                            </time>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-lg mb-3 text-gray-800 leading-tight group-hover:text-green-700 transition-colors duration-300">
                            <a href="{{ route('berita.show', $item) }}" class="block">
                                {{ $item->title }}
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <div class="text-gray-600 text-sm leading-relaxed mb-4 flex-grow">
                            {!! \Illuminate\Support\Str::limit(strip_tags($item->content), 120) !!}
                        </div>
                    </div>
                </article>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
                        <!-- Official Icon -->
                        <div class="w-20 h-20 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        
                        <!-- Official Message -->
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">
                            BELUM ADA BERITA TERPUBLIKASI
                        </h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-2 max-w-md mx-auto">
                            Informasi berita dan pengumuman resmi akan ditampilkan di halaman ini secara berkala.
                        </p>
                        <p class="text-gray-500 text-xs">
                            Pantau terus untuk mendapatkan informasi terbaru dari kami.
                        </p>

                        <!-- Official Badge -->
                        <div class="inline-flex items-center mt-6 px-3 py-1 bg-green-50 border border-green-200 rounded-full">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-xs font-medium text-green-700">INFORMASI RESMI</span>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- View All News Button -->
        {{-- <div class="text-center mt-12">
            <div class="inline-flex flex-col items-center">
                <a href="{{ route('berita.index') }}" class="inline-flex items-center bg-green-600 text-white font-semibold px-8 py-3 rounded-lg hover:bg-green-700 transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 group">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <span>LIHAT SEMUA BERITA</span>
                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div> --}}

    </div>
</section>
