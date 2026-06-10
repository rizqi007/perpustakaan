{{-- 
    File: resources/views/partials/header.blade.php
    Deskripsi: Komponen header/navbar mengambang yang terinspirasi dari situs Perpusnas.
    Memerlukan Alpine.js dan Tailwind CSS yang sudah dimuat di layout utama.
--}}

{{-- 
    Header diubah menjadi navbar mengambang yang interaktif saat scroll.
    - x-data: Menambah state untuk 'showNavbar' dan 'lastScrollY'.
    - @scroll.window: Mendeteksi event scroll pada window.
    - :class: Mengubah posisi 'top' secara dinamis berdasarkan state 'showNavbar'.
    - transition-all & duration-300: Menambahkan animasi yang mulus.
--}}
<header 
    x-data="{
        mobileMenuOpen: false,
        showNavbar: true,
        lastScrollY: window.scrollY
    }"
    @scroll.window="
        if (window.scrollY > lastScrollY && window.scrollY > 100) {
            showNavbar = false;
        } else {
            showNavbar = true;
        }
        lastScrollY = window.scrollY;
    "
    class="fixed left-1/2 -translate-x-1/2 w-[95%] max-w-7xl z-50 bg-white shadow-xl rounded-full border border-gray-200 transition-all duration-300 ease-in-out"
    :class="{ 'top-5': showNavbar, '-top-24': !showNavbar }"
>
    
    {{-- Navigasi Utama --}}
    <nav class="container mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center space-x-3" title="PERPUSTAKAAN KEMENTERIAN AGAMA RI">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Perpustakaan Kemenag RI" class="h-10 w-10">
                    {{-- Teks logo ditampilkan kembali di sebelah logo --}}
                    <div class="ml-3">
                        <h1 class="font-bold text-base text-gray-800 tracking-tight">PERPUSTAKAAN KEMENAG RI</h1>
                        <p class="text-xs text-gray-500">NPP 3171064C1019901</p>
                    </div>
                </a>
            </div>

            {{-- Navigasi Desktop (Tengah) --}}
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-green-600 font-medium px-4 py-2 rounded-full transition-all duration-200 hover:bg-green-50">Beranda</a>
                
                {{-- Dropdown: Tentang Kami (membuka ke bawah) --}}
                <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                    <button class="flex items-center text-gray-700 hover:text-green-600 font-medium px-4 py-2 rounded-full transition-all duration-200 hover:bg-green-50 group">
                        <span>Tentang Kami</span>
                        <svg class="w-4 h-4 ml-1 transform transition-transform duration-200 group-hover:rotate-180" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                        class="absolute top-full left-1/2 transform -translate-x-1/2 mt-3 w-80 rounded-2xl shadow-xl bg-white ring-1 ring-gray-200 py-2 border border-gray-100"
                        style="display: none;"
                    >
                        <div class="py-1">
                            <a href="{{ url('/tentang/profil') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700 transition-all duration-200 group">
                                <svg class="w-4 h-4 mr-3 text-green-500 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <div>
                                    <div class="font-medium">Profil</div>
                                    <div class="text-xs text-gray-500">Tentang perpustakaan kami</div>
                                </div>
                            </a>
                            <a href="{{ url('/tentang/sejarah') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700 transition-all duration-200 group">
                                <svg class="w-4 h-4 mr-3 text-green-500 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <div class="font-medium">Sejarah</div>
                                    <div class="text-xs text-gray-500">Perjalanan dan perkembangan</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <a href="{{ url('/berita') }}" class="text-gray-700 hover:text-green-600 font-medium px-4 py-2 rounded-full transition-all duration-200 hover:bg-green-50">Berita</a>
                <a href="{{ url('/hubungi-kami') }}" class="text-gray-700 hover:text-green-600 font-medium px-4 py-2 rounded-full transition-all duration-200 hover:bg-green-50">Hubungi Kami</a>
                <a href="{{ url('/#testimoni') }}" class="text-gray-700 hover:text-green-600 font-medium px-4 py-2 rounded-full transition-all duration-200 hover:bg-green-50">Testimoni</a>
            </div>
            
            {{-- Pencarian (Kanan) --}}
            <div class="hidden lg:flex items-center">
                <div class="relative">
                    <input type="text" placeholder="Pencarian..." class="bg-gray-100 text-gray-700 text-sm rounded-full py-2 pl-4 pr-10 focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white w-40 transition-all duration-300 focus:w-56 border border-gray-200">
                    <svg class="w-5 h-5 text-gray-400 absolute top-1/2 right-3 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                </div>
            </div>
            
            {{-- Tombol Hamburger Menu --}}
            <div class="lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-full text-gray-700 hover:text-green-600 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200" aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- Navigasi Mobile (Dropdown membuka ke bawah) --}}
    <div 
        x-show="mobileMenuOpen" 
        @click.away="mobileMenuOpen = false" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
        class="lg:hidden absolute top-full left-1/2 -translate-x-1/2 w-screen max-w-md mt-3" 
        style="display: none;"
    >
        <div class="bg-white rounded-2xl shadow-xl ring-1 ring-gray-200 p-4 border border-gray-100">
            <div class="px-2 pt-2 pb-3 space-y-2 sm:px-3">
                {{-- Mobile Search Bar --}}
                <div class="px-2 pb-3">
                    <div class="relative">
                        <input type="text" placeholder="Pencarian..." class="w-full bg-gray-100 text-gray-700 text-sm rounded-full py-2 pl-4 pr-10 focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white border border-gray-200">
                        <svg class="w-5 h-5 text-gray-400 absolute top-1/2 right-3 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                    </div>
                </div>

                <a href="{{ url('/') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-200">Beranda</a>
                
                {{-- Dropdown Mobile: Tentang Kami --}}
                <div x-data="{ open: false }" class="rounded-xl overflow-hidden">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-200">
                        <span>Tentang Kami</span>
                        <svg class="w-5 h-5 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-40"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 max-h-40"
                        x-transition:leave-end="opacity-0 max-h-0"
                        class="bg-gray-50 rounded-xl mx-2 mt-1 overflow-hidden"
                    >
                        <div class="py-2">
                            <a href="{{ url('/tentang/profil') }}" class="flex items-center px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-white transition-all duration-200 mx-2">
                                <svg class="w-4 h-4 mr-2 text-green-500 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profil
                            </a>
                            <a href="{{ url('/tentang/sejarah') }}" class="flex items-center px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-white transition-all duration-200 mx-2">
                                <svg class="w-4 h-4 mr-2 text-green-500 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Sejarah
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/berita') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-200">Berita</a>
                <a href="{{ url('/hubungi-kami') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-200">Hubungi Kami</a>
                <a href="{{ url('/#testimoni') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-200">Testimoni</a>
            </div>
        </div>
    </div>
</header>