{{-- 
    File: resources/views/partials/hero.blade.php
    Deskripsi: Komponen hero dengan slider banner.
--}}
<section class="relative overflow-hidden">
    {{-- Cek apakah ada banner yang aktif untuk ditampilkan --}}
    @if($banners->isNotEmpty())
        {{-- Kontainer utama untuk Swiper Slider --}}
        <div class="swiper hero-slider" data-swiper-config='{"loop": true, "navigation": {"nextEl": ".swiper-button-next", "prevEl": ".swiper-button-prev"}, "pagination": {"el": ".swiper-pagination", "clickable": true}}'>
            {{-- Wrapper yang dibutuhkan oleh Swiper untuk semua slide --}}
            <div class="swiper-wrapper">
                {{-- Looping untuk setiap banner dari database --}}
                @foreach($banners as $banner)
                    <div class="swiper-slide">
                        {{-- Container dengan height full screen --}}
                        <div class="relative w-full h-screen overflow-hidden">
                            {{-- Background image dengan background-size: cover --}}
                            <div class="absolute inset-0 bg-cover bg-center" 
                                 style="background-image: url('{{ asset('storage/' . $banner->image) }}');">
                            </div>
                            
                            {{-- Gradient overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-black/30"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/40"></div>
                            
                            {{-- Icon Media Sosial Mengambang - Desktop: kanan vertikal, Mobile: bawah center horizontal --}}
                            <div class="absolute left-1/2 -translate-x-1/2 bottom-6 md:left-auto md:translate-x-0 md:right-16 lg:right-20 md:top-1/2 md:-translate-y-1/2 md:bottom-auto z-20 flex flex-row md:flex-col gap-3 sm:gap-4 mt-12">
                                {{-- Instagram --}}
                                <a href="https://www.instagram.com/perpuskemenagri/" target="_blank" class="group flex items-center justify-center w-12 h-12 md:w-12 md:h-12 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 hover:bg-gradient-to-br hover:from-purple-600 hover:via-pink-600 hover:to-orange-500 transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-pink-500/50">
                                    <svg class="w-6 h-6 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                                
                                {{-- YouTube --}}
                                <a href="https://www.youtube.com/@perpustakaankementerianaga1505" target="_blank" class="group flex items-center justify-center w-12 h-12 md:w-12 md:h-12 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 hover:bg-red-600 transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-red-500/50">
                                    <svg class="w-6 h-6 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                </a>
                                
                                {{-- Facebook --}}
                                <a href="https://www.facebook.com/PerpusKemenagRI/" target="_blank" class="group flex items-center justify-center w-12 h-12 md:w-12 md:h-12 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 hover:bg-blue-600 transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-blue-500/50">
                                    <svg class="w-6 h-6 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                
                                {{-- X (Twitter) --}}
                                {{-- <a href="#" target="_blank" class="group flex items-center justify-center w-12 h-12 md:w-12 md:h-12 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 hover:bg-black transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-gray-700/50">
                                    <svg class="w-6 h-6 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </a> --}}
                            </div>
                            
                            {{-- Konten utama --}}
                            <div class="relative z-10 w-full h-full flex flex-col justify-center items-start px-4 sm:px-6 md:px-12 lg:px-16 xl:px-24 pb-24 md:pb-0 mt-15">
                                <div class="max-w-4xl space-y-4 sm:space-y-6">
                                    {{-- Judul utama --}}
                                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight">
                                        <span class="block drop-shadow-2xl">{{ $banner->title }}</span>
                                    </h1>
                                    
                                    {{-- Deskripsi --}}
                                    <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-white/90 max-w-2xl sm:max-w-3xl leading-relaxed drop-shadow-lg">
                                        {{ $banner->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        {{-- Fallback content ketika tidak ada banner --}}
        <div class="relative w-full h-screen overflow-hidden">
            {{-- Default background dengan gradient --}}
            <div class="absolute inset-0 bg-gradient-to-br from-green-900 via-green-800 to-teal-900"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/30"></div>
            
            {{-- Icon Media Sosial Mengambang - Desktop: kanan vertikal, Mobile: bawah center horizontal --}}
            <div class="absolute left-1/2 -translate-x-1/2 bottom-6 md:left-auto md:translate-x-0 md:right-16 lg:right-20 md:top-1/2 md:-translate-y-1/2 md:bottom-auto z-20 flex flex-row md:flex-col gap-3 sm:gap-4">
                {{-- Instagram --}}
                <a href="https://www.instagram.com/perpuskemenagri/" target="_blank" class="group flex items-center justify-center w-12 h-12 md:w-12 md:h-12 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 hover:bg-gradient-to-br hover:from-purple-600 hover:via-pink-600 hover:to-orange-500 transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-pink-500/50">
                    <svg class="w-6 h-6 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                
                {{-- YouTube --}}
                <a href="https://www.youtube.com/@perpustakaankementerianaga1505" target="_blank" class="group flex items-center justify-center w-12 h-12 md:w-12 md:h-12 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 hover:bg-red-600 transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-red-500/50">
                    <svg class="w-6 h-6 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
                
                {{-- Facebook --}}
                <a href="https://www.facebook.com/PerpusKemenagRI/" target="_blank" class="group flex items-center justify-center w-12 h-12 md:w-12 md:h-12 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 hover:bg-blue-600 transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-blue-500/50">
                    <svg class="w-6 h-6 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                
                {{-- X (Twitter) --}}
                {{-- <a href="#" target="_blank" class="group flex items-center justify-center w-12 h-12 md:w-12 md:h-12 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 hover:bg-black transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-gray-700/50">
                    <svg class="w-6 h-6 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a> --}}
            </div>
            
            {{-- Konten utama --}}
            <div class="relative z-10 w-full h-full flex flex-col justify-center items-center text-center px-4 sm:px-6 md:px-8 pb-24 md:pb-0">
                <div class="space-y-4 sm:space-y-6 max-w-4xl">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-bold text-white mb-4 sm:mb-6 drop-shadow-2xl">
                        Selamat Datang
                    </h1>
                    <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-white/90 leading-relaxed drop-shadow-lg max-w-2xl sm:max-w-3xl mx-auto">
                        Website sedang dalam pengembangan. Silakan unggah banner dari dashboard admin untuk menampilkan konten yang menarik.
                    </p>
                    <div class="pt-6 sm:pt-8">
                        <a href="#" class="group inline-block px-6 py-3 sm:px-8 sm:py-4 bg-white text-green-900 font-semibold rounded-full hover:bg-transparent hover:text-white border-2 border-white transition-all duration-300 text-sm sm:text-base">
                            <span class="flex items-center gap-2">
                                Dashboard Admin
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>