<div class="bg-white" @search-services.window="$wire.set('search', $event.detail)">
    <!-- Banner Section -->
    <section class="relative bg-emerald-900 text-white h-screen flex items-center overflow-hidden">
        @if($banners->count() > 0)
            <div x-data="{ activeSlide: 0, slides: {{ $banners->count() }}, timer: null }"
                 x-init="timer = setInterval(() => { activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1 }, 5000)"
                 class="absolute inset-0 w-full h-full">
                @foreach($banners as $index => $banner)
                    <div x-show="activeSlide === {{ $index }}"
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-1000"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute inset-0 w-full h-full">
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover opacity-50">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-900 via-emerald-900/80 to-transparent"></div>
                        
                        <div class="absolute inset-0 flex items-center justify-center px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pt-20">
                            <div class="w-full">
                                <div class="max-w-5xl animate-fade-in-up">
                                    <span class="text-emerald-300 font-bold tracking-widest uppercase mb-2 block">Selamat Datang</span>
                                    <h2 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                                        Perpustakaan <br>
                                        <span class="text-emerald-400">Kementerian Agama RI</span>
                                    </h2>
                                    <p class="text-lg md:text-xl text-gray-200 mb-4 leading-relaxed">
                                        {{ $banner->description ?? 'Literate to Moderate' }}
                                    </p>
                                    @if($websiteSettings->notification_banner_enabled && $websiteSettings->notification_banner_text)
                                        <div class="mb-6 px-4 py-2.5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full inline-flex items-center gap-2 text-sm text-amber-200 animate-pulse">
                                            <svg class="w-4 h-4 flex-shrink-0 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                            <span>{{ $websiteSettings->notification_banner_text }}</span>
                                        </div>
                                    @endif
                                    <div class="flex space-x-4">
                                        <a href="#layanan" class="px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-full transition shadow-lg hover:shadow-emerald-500/50">
                                            Jelajahi Layanan
                                        </a>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                @endforeach
                

            </div>
        @else
            <!-- Default Static Banner -->
            <div class="absolute inset-0 w-full h-full">
                 <div class="absolute inset-0 bg-gradient-to-r from-emerald-900 via-emerald-900/80 to-transparent z-10"></div>
                 <img src="https://images.unsplash.com/photo-1541963463532-d68292c34b19?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover opacity-50 absolute inset-0 mix-blend-overlay">
                 
                  <div class="relative z-20 h-full flex items-center max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20">
                     <div class="w-full">
                         <div class="max-w-5xl">
                             <span class="text-emerald-300 font-bold tracking-widest uppercase mb-2 block animate-fade-in">Selamat Datang di</span>
                             <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight text-white">
                                 Perpustakaan <br>
                                 <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">Kementerian Agama RI</span>
                             </h1>
                             <p class="text-xl text-gray-300 mb-4 max-w-2xl leading-relaxed">
                                 Literate to Moderate. Mewujudkan masyarakat yang literat dan moderat melalui layanan perpustakaan yang prima.
                             </p>
                             @if($websiteSettings->notification_banner_enabled && $websiteSettings->notification_banner_text)
                                 <div class="mb-6 px-4 py-2.5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full inline-flex items-center gap-2 text-sm text-amber-200 animate-pulse">
                                     <svg class="w-4 h-4 flex-shrink-0 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                     <span>{{ $websiteSettings->notification_banner_text }}</span>
                                 </div>
                             @endif
                              <div class="flex flex-wrap gap-4">
                                 <a href="#layanan" class="px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-full transition shadow-lg hover:shadow-emerald-500/50">
                                     Jelajahi Layanan
                                 </a>
     
                             </div>
                         </div>


                     </div>
                  </div>
            </div>
        @endif
    </section>

    <!-- Layanan Section -->
    <section id="layanan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="{ activeLayanan: null }">
        <div class="text-center mb-16">
            <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Fasilitas & Akses</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mt-2">Layanan Perpustakaan</h2>
            <div class="w-24 h-1.5 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Akses mudah dan cepat untuk berbagai layanan digital dan fisik perpustakaan terpadu.</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-6">
            @foreach($layanans as $layanan)
                <a href="#" 
                   @click.prevent="activeLayanan = { 
                        name: '{{ addslashes($layanan->name) }}', 
                        description: `{{ $layanan->description ?? 'Deskripsi layanan ini belum tersedia.' }}`, 
                        url: '{{ $layanan->url }}', 
                        image: '{{ $layanan->image ? asset('storage/' . $layanan->image) : null }}' 
                   }" 
                   class="w-[calc(50%-0.75rem)] md:w-[calc(25%-1.125rem)] group bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 p-6 flex items-center transition-all duration-300 hover:-translate-y-1">
                    <div class="mr-4 flex-shrink-0">
                         @if($layanan->image)
                            <img src="{{ asset('storage/' . $layanan->image) }}" alt="{{ $layanan->name }}" class="w-12 h-12 object-contain group-hover:scale-110 transition-transform">
                        @else
                            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm md:text-base font-bold text-gray-800 group-hover:text-emerald-700 transition-colors">{{ $layanan->name }}</h3>
                    </div>
                </a>
            @endforeach
            
            <!-- Hardcoded examples if empty to match design -->
            @if($layanans->count() == 0 && $openResources->count() == 0)
                @php
                    $defaults = ['Perpustakaan Digital', 'E-Resources', 'Member Area', 'OPAC', 'Kunjungan', 'Pojok Baca Digital', 'Hibah Buku', 'Mini Theater'];
                @endphp
                @foreach($defaults as $def)
                 <a href="#" class="w-[calc(50%-0.75rem)] md:w-[calc(25%-1.125rem)] group bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 p-6 flex items-center transition-all duration-300 hover:-translate-y-1">
                    <div class="mr-4 flex-shrink-0">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm md:text-base font-bold text-gray-800 group-hover:text-emerald-700 transition-colors">{{ $def }}</h3>
                    </div>
                </a>
                @endforeach
            @endif
        </div>

        @if($openResources->count() > 0)
            <div class="text-center mb-10 mt-16">
                <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Sumber Terbuka</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mt-2">Open Resource</h2>
                <div class="w-24 h-1.5 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                @foreach($openResources as $resource)
                    <a href="#" 
                       @click.prevent="activeLayanan = { 
                            name: '{{ addslashes($resource->name) }}', 
                            description: `{{ $resource->description ?? 'Deskripsi layanan ini belum tersedia.' }}`, 
                            url: '{{ $resource->url }}', 
                            image: '{{ $resource->image ? asset('storage/' . $resource->image) : null }}' 
                       }" 
                       class="w-[calc(50%-0.75rem)] md:w-[calc(25%-1.125rem)] group bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 p-6 flex items-center transition-all duration-300 hover:-translate-y-1">
                        <div class="mr-4 flex-shrink-0">
                             @if($resource->image)
                                <img src="{{ asset('storage/' . $resource->image) }}" alt="{{ $resource->name }}" class="w-12 h-12 object-contain group-hover:scale-110 transition-transform">
                            @else
                                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm md:text-base font-bold text-gray-800 group-hover:text-emerald-700 transition-colors">{{ $resource->name }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Modal -->
        <div x-show="activeLayanan" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
             style="display: none;">
            
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
                 x-show="activeLayanan"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="activeLayanan = null"></div>

            <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-xl max-w-md w-full overflow-hidden transform transition-all"
                 x-show="activeLayanan"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                 
                <div class="p-6">
                    <div class="flex flex-col items-center text-center">
                        <template x-if="activeLayanan?.image">
                            <img :src="activeLayanan.image" class="w-20 h-20 object-contain mb-4">
                        </template>
                        <template x-if="!activeLayanan?.image">
                             <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </template>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-2" x-text="activeLayanan?.name"></h3>
                        <div class="text-gray-600 mb-6 text-sm leading-relaxed whitespace-pre-line" x-html="activeLayanan?.description"></div>
                        
                        <div class="flex gap-3 w-full">
                            <button @click="activeLayanan = null" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                                Tutup
                            </button>
                            <a :href="activeLayanan?.url" target="_blank" 
                               x-show="activeLayanan?.url && activeLayanan.url !== ''"
                               class="flex-1 px-4 py-2 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                                Buka Layanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Digital & Booking Section -->
    <section class="bg-white py-16" id="layanan-digital">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Left Column: Formulir Online -->
                <div class="space-y-6">
                    <div class="text-left mb-6">
                        <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Layanan Digital</span>
                        <h2 class="text-3xl font-bold text-gray-900 mt-2">Formulir Online</h2>
                        <div class="w-16 h-1.5 bg-emerald-500 mt-4 rounded-full"></div>
                        <p class="mt-4 text-gray-600 text-sm">Isi formulir pelayanan perpustakaan secara online dengan mudah dan cepat.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach($forms as $form)
                            <a href="{{ $form->slug === 'pengajuan-isbn' ? route('dashboard') : route('form.show', $form->slug) }}" class="group bg-white rounded-xl shadow-sm hover:shadow-lg border border-gray-100 p-5 flex items-center transition-all duration-300 hover:-translate-y-1">
                                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex-shrink-0 flex items-center justify-center mr-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-emerald-600 transition-colors truncate">{{ $form->title }}</h3>
                                    <p class="text-xs text-gray-500 line-clamp-1">{{ !empty(trim(strip_tags($form->description))) ? strip_tags($form->description) : 'Klik untuk mengisi.' }}</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-300 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @endforeach

                        @if($forms->isEmpty())
                            <div class="p-6 bg-white rounded-xl border border-dashed border-gray-300 text-center text-gray-500 text-sm">
                                Belum ada formulir yang tersedia.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Booking Calendar -->
                <div>
                     <livewire:front.booking-calendar />
                </div>

            </div>
        </div>
    </section>

    <!-- Daftar Anggota CTA Section -->
    <section class="py-16 bg-gradient-to-br from-emerald-50 via-white to-teal-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-emerald-700 via-emerald-800 to-teal-900 rounded-3xl overflow-hidden shadow-2xl">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mt-16 -mr-16 w-80 h-80 bg-emerald-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-80 h-80 bg-teal-500/20 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-600/10 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row items-center gap-10 p-8 md:p-12 lg:p-16">
                    <!-- Left: Icon + Visual -->
                    <div class="flex-shrink-0">
                        <div class="w-36 h-36 md:w-44 md:h-44 bg-white/10 backdrop-blur-sm rounded-3xl border border-white/20 flex items-center justify-center transform rotate-[-6deg] hover:rotate-0 transition-transform duration-500 shadow-xl">
                            <div class="text-center">
                                <svg class="w-16 h-16 md:w-20 md:h-20 text-emerald-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                <span class="text-emerald-200 text-xs font-bold mt-2 block tracking-wider uppercase">Member</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Content -->
                    <div class="flex-1 text-center lg:text-left">
                        <span class="inline-block px-3 py-1 bg-emerald-500/20 text-emerald-300 text-xs font-bold rounded-full uppercase tracking-wider border border-emerald-400/30 mb-4">Keanggotaan Perpustakaan</span>
                        <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-white mb-4 leading-tight">
                            Daftar Menjadi Anggota <br class="hidden md:block">Perpustakaan
                        </h2>
                        <p class="text-emerald-100/80 text-lg mb-8 max-w-2xl leading-relaxed">
                            Bergabunglah sebagai anggota untuk mendapatkan akses penuh ke seluruh layanan perpustakaan. Proses pendaftaran mudah dan cepat — kartu anggota digital akan diterbitkan setelah verifikasi admin.
                        </p>

                        <!-- Benefits -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                                <div class="w-10 h-10 bg-emerald-500/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" /></svg>
                                </div>
                                <span class="text-white text-sm font-semibold">Kartu Anggota Digital</span>
                            </div>
                            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                                <div class="w-10 h-10 bg-emerald-500/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                </div>
                                <span class="text-white text-sm font-semibold">Akses Katalog Penuh</span>
                            </div>
                            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                                <div class="w-10 h-10 bg-emerald-500/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                </div>
                                <span class="text-white text-sm font-semibold">Riwayat Peminjaman</span>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('daftar.anggota') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-emerald-800 font-bold rounded-xl shadow-lg shadow-emerald-900/30 hover:shadow-emerald-900/50 hover:bg-emerald-50 hover:-translate-y-1 transition-all duration-300 text-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                                Daftar Sekarang
                            </a>
                            <a href="{{ route('kartu.anggota') }}" class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white border-2 border-white/30 font-bold rounded-xl hover:bg-white/10 hover:border-white/50 transition-all duration-300 text-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
                                Cetak Kartu Anggota
                            </a>
                        </div>
                        <p class="mt-4 text-xs text-emerald-300/60 font-medium">
                            *Anda perlu login terlebih dahulu untuk melakukan pendaftaran anggota.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan ISBN Section -->
    <section class="py-16 bg-white border-t border-gray-100" x-data="{ activeIsbn: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            
            <!-- call to action isbn -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-3xl p-8 md:p-12 border border-emerald-100 flex flex-col md:flex-row items-center gap-8 md:gap-12 relative overflow-hidden mb-12">
                <!-- Decorative Background Pattern -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-emerald-100/50 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-teal-100/50 rounded-full blur-3xl"></div>

                <!-- Icon Section (Left) -->
                <div class="flex-shrink-0 relative z-10">
                    <div class="w-32 h-32 md:w-40 md:h-40 bg-white rounded-full shadow-xl flex items-center justify-center border-4 border-emerald-50 transform rotate-[-5deg] hover:rotate-0 transition-transform duration-300">
                        <svg class="w-16 h-16 md:w-20 md:h-20 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9h-2V7h2v2zm0-4h-2V3h2v2zm-4 4h-2V7h2v2zm0-4h-2V3h2v2zm-4 4H9V7h2v2zm0-4H9V3h2v2z"/>
                        </svg>
                    </div>
                </div>

                <!-- Text & Button Section (Right) -->
                <div class="flex-1 text-center md:text-left relative z-10">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                        Daftarkan Karya Tulis Anda Melalui Layanan ISBN
                    </h3>
                    <p class="text-gray-600 mb-8 text-lg leading-relaxed max-w-2xl">
                        Dapatkan International Standard Book Number (ISBN) resmi untuk buku terbitan Anda. Proses pengajuan mudah, cepat, dan terintegrasi langsung melalui dashboard kami.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 hover:shadow-emerald-300 hover:bg-emerald-700 hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Ajukan ISBN Sekarang
                        </a>
                        <a href="{{ route('isbn.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-emerald-700 border-2 border-emerald-100 font-bold rounded-xl hover:bg-emerald-50 hover:border-emerald-200 transition-all duration-300">
                            Lihat Riwayat
                        </a>
                    </div>
                    <p class="mt-4 text-xs text-gray-400 font-medium">
                        *Anda perlu login untuk melakukan pengajuan.
                    </p>
                </div>
            </div>

            <!-- Showcase Buku ISBN -->
            @if(isset($isbnBooks) && $isbnBooks->count() > 0)
                <div class="mt-12">
                    <div class="text-center mb-10">
                        <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Karya Terbaru</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Buku Ber-ISBN Terdaftar</h2>
                        <div class="w-24 h-1.5 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
                        <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Koleksi terbitan terbaru yang telah mendapatkan nomor ISBN resmi melalui layanan kami.</p>
                        <a href="{{ route('katalog.index') }}" class="inline-flex items-center text-emerald-600 font-semibold text-sm hover:text-emerald-800 transition mt-3">
                            Lihat Semua
                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-8">
                        @foreach($isbnBooks as $book)
                            @php
                                $coverPath = $book->cover ?? null;
                                $isImage = $coverPath && preg_match('/\.(jpg|jpeg|png|webp|gif|avif)$/i', $coverPath);
                                $coverUrl = $coverPath ? asset('storage/' . $coverPath) : '';
                            @endphp

                            <a href="{{ route('katalog.show', $book->id) }}" class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 block" style="height: 380px;">
                                {{-- Cover Image --}}
                                @if($isImage)
                                    <img src="{{ $coverUrl }}" alt="{{ $book->judul_penanggung_jawab }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @else
                                    <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-emerald-700 to-teal-900 flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                @endif

                                {{-- Dark Gradient Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>

                                {{-- Content at bottom --}}
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    @if($book->identifikasi)
                                        <span class="inline-block px-2.5 py-0.5 bg-gray-800/80 text-white text-[10px] font-bold rounded mb-2 uppercase tracking-wide border border-white/20">
                                            {{ $book->identifikasi }}
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 bg-gray-800/80 text-white text-[10px] font-bold rounded mb-2 uppercase tracking-wide border border-white/20">
                                            NONE
                                        </span>
                                    @endif

                                    <h3 class="text-white text-sm md:text-base font-bold leading-tight line-clamp-2 group-hover:text-emerald-300 transition-colors">
                                        {{ Str::title($book->judul_penanggung_jawab) }}
                                    </h3>

                                    @if($book->publikasi || $book->edisi)
                                        <div class="flex items-center justify-between mt-1">
                                            <p class="text-gray-300 text-xs line-clamp-1">
                                                {{ $book->publikasi ?? $book->edisi }}
                                            </p>
                                            @if($book->edisi && $book->publikasi)
                                                <span class="text-gray-400 text-[10px] font-medium shrink-0 ml-2">{{ Str::limit($book->edisi, 15) }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Modal Khusus ISBN -->
            <div x-show="activeIsbn" 
                class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                style="display: none;">
                
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
                    x-show="activeIsbn"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click="activeIsbn = null"></div>

                <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-xl max-w-2xl w-full overflow-hidden transform transition-all flex flex-col max-h-[90vh]"
                    x-show="activeIsbn"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="flex flex-col md:flex-row h-full overflow-hidden">
                        <!-- Kolom Gambar -->
                        <div class="w-full md:w-2/5 md:bg-gray-50 flex-shrink-0 relative overflow-hidden flex items-center justify-center p-6 border-b md:border-b-0 md:border-r border-gray-100">
                            <!-- Background blurring for visual effect -->
                            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat blur-[40px] opacity-30 scale-125" :style="`background-image: url('${activeIsbn?.image}')`" x-show="activeIsbn?.image && !activeIsbn?.isPdf"></div>
                            
                            <template x-if="activeIsbn?.image && !activeIsbn?.isPdf">
                                <img :src="activeIsbn.image" class="relative z-10 w-full max-w-[200px] shadow-2xl rounded rounded-r-xl object-contain h-auto aspect-[3/4]">
                            </template>
                            <template x-if="activeIsbn?.image && activeIsbn?.isPdf">
                                <div class="relative z-10 w-full max-w-[200px] aspect-[3/4] flex flex-col items-center justify-center bg-emerald-50 text-emerald-600 rounded shadow-2xl">
                                    <svg class="w-20 h-20 mb-3 opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9h-2V7h2v2zm0-4h-2V3h2v2zm-4 4h-2V7h2v2zm0-4h-2V3h2v2zm-4 4H9V7h2v2zm0-4H9V3h2v2z"/></svg>
                                    <span class="text-sm font-semibold bg-white px-3 py-1.5 rounded shadow-sm border border-emerald-100">PDF Document</span>
                                </div>
                            </template>
                            <template x-if="!activeIsbn?.image">
                                <div class="relative z-10 w-full max-w-[200px] aspect-[3/4] bg-gray-200 rounded shadow-2xl flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <span class="text-sm">Tidak ada Cover</span>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Kolom Detail -->
                        <div class="w-full md:w-3/5 p-6 md:p-8 flex flex-col h-[60vh] md:h-auto md:max-h-[80vh] overflow-y-auto custom-scrollbar">
                            <button @click="activeIsbn = null" class="absolute top-4 right-4 p-2 bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-600 rounded-full transition-colors z-10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <h3 class="text-2xl font-bold text-gray-900 mb-2 leading-tight" x-text="activeIsbn?.title"></h3>
                            
                            <p class="text-emerald-700 font-medium mb-6" x-show="activeIsbn?.author">
                                Oleh: <span class="font-bold text-gray-800" x-text="activeIsbn?.author"></span>
                            </p>
                            
                            <!-- Badges Info -->
                            <div class="flex flex-wrap gap-2 mb-6" x-show="activeIsbn?.pages || activeIsbn?.size">
                                <template x-if="activeIsbn?.pages">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded bg-gray-50 border border-gray-100 text-xs font-medium text-gray-600">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <span x-text="activeIsbn.pages"></span>&nbsp;Hal
                                    </div>
                                </template>
                                <template x-if="activeIsbn?.size">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded bg-gray-50 border border-gray-100 text-xs font-medium text-gray-600">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                        <span x-text="activeIsbn.size"></span>&nbsp;cm
                                    </div>
                                </template>
                            </div>

                            <div class="mb-4">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 border-b border-gray-100 pb-2">Sinopsis</h4>
                                <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line" x-html="activeIsbn?.synopsis || '<em class=\'text-gray-400\'>Tidak ada sinopsis tersedia.</em>'"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== KEGIATAN PERPUSTAKAAN SECTION ===== --}}
    @if($kegiatans->count() > 0)
    <section class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Agenda & Dokumentasi</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Kegiatan Perpustakaan</h2>
                <div class="w-24 h-1.5 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                @foreach($kegiatans as $kegiatan)
                    <a href="{{ route('kegiatan.show', $kegiatan->slug) }}" class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 block w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] max-w-[340px]" style="height: 380px;">
                        <!-- Cover Image -->
                        @if($kegiatan->cover_image)
                            <img src="{{ asset('storage/' . $kegiatan->cover_image) }}" alt="{{ $kegiatan->judul }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-emerald-700 to-teal-900 flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            </div>
                        @endif

                        <!-- Dark Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/40 to-transparent"></div>

                        <!-- Content at bottom -->
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <!-- Tag Badge -->
                            <span class="inline-block px-2.5 py-0.5 bg-gray-800/80 text-white text-[10px] font-bold rounded mb-2.5 uppercase tracking-wide border border-white/20">
                                {{ $kegiatan->kategori_label }}
                            </span>

                            <!-- Title & Speakers -->
                            <h3 class="text-white text-sm md:text-base font-bold leading-tight line-clamp-2 group-hover:text-emerald-300 transition-colors">
                                {{ $kegiatan->judul }}
                                @if($kegiatan->narasumber && count($kegiatan->narasumber) > 0)
                                    / {{ collect($kegiatan->narasumber)->pluck('nama')->first() }}
                                @endif
                            </h3>

                            <!-- Date and Action -->
                            <div class="flex items-center justify-between mt-2 text-xs text-gray-300">
                                <span>{{ $kegiatan->tanggal_mulai->translatedFormat('Y') }}</span>
                                <span class="text-emerald-400 group-hover:translate-x-1 transition-transform inline-flex items-center gap-1 font-semibold">
                                    Lihat
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Update Informasi</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Berita Terkini</h2>
                <div class="w-24 h-1.5 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
                <a href="{{ route('berita.index') }}" class="inline-flex items-center text-emerald-600 font-semibold text-sm hover:text-emerald-800 transition mt-3">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($beritas as $berita)
                    <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 flex flex-col h-full">
                        <div class="relative overflow-hidden h-56">
                            @if($berita->image)
                                <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">Berita</span>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center text-xs text-gray-500 mb-3 space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ $berita->created_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-emerald-600 transition-colors">
                                <a href="{{ route('berita.show', $berita->slug ?? $berita->id) }}">
                                    {{ $berita->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-1">
                                {{ Str::limit(strip_tags($berita->content), 120) }}
                            </p>
                            <a href="{{ route('berita.show', $berita->slug ?? $berita->id) }}" class="inline-flex items-center text-emerald-600 font-semibold text-sm hover:underline mt-auto">
                                Baca Selengkapnya <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Resensi Slider Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Ulasan Buku</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Resensi Terkini</h2>
                <div class="w-24 h-1.5 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
            </div>

            @if($resensis->count() > 0)
                <div x-data="{ 
                        activeSlide: 0, 
                        total: {{ $resensis->count() }},
                        visibleSlides: window.innerWidth >= 768 ? 3 : 1,
                        get maxSlide() { return Math.max(0, this.total - this.visibleSlides) },
                        next() { 
                            if (this.activeSlide < this.maxSlide) {
                                this.activeSlide++
                            } else {
                                this.activeSlide = 0 
                            }
                        },
                        prev() { 
                            if (this.activeSlide > 0) {
                                this.activeSlide--
                            } else {
                                this.activeSlide = this.maxSlide
                            }
                        },
                        autoPlay() { setInterval(() => this.next(), 6000) }
                     }"
                     x-init="$watch('window.innerWidth', value => visibleSlides = value >= 768 ? 3 : 1); autoPlay()"
                     @resize.window="visibleSlides = window.innerWidth >= 768 ? 3 : 1"
                     class="relative group px-4 md:px-12">
                    
                    <!-- Slides Container -->
                    <div class="overflow-hidden py-4 -my-4">
                        <div class="flex transition-transform duration-500 ease-in-out"
                             :style="'transform: translateX(-' + (activeSlide * (100 / visibleSlides)) + '%)'">
                            @foreach($resensis as $index => $resensi)
                                <div class="w-full md:w-1/3 flex-shrink-0 px-3" :style="'flex: 0 0 ' + (100 / visibleSlides) + '%'">
                                    <a href="{{ route('landing') }}/resensi/{{ $resensi->slug }}" class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 block" style="height: 380px;">
                                        <!-- Cover Image -->
                                        @if($resensi->cover_image)
                                            <img src="{{ asset('storage/' . $resensi->cover_image) }}" alt="{{ $resensi->book_title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                        @else
                                            <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-emerald-700 to-teal-900 flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                        @endif

                                        <!-- Dark Gradient Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/40 to-transparent"></div>

                                        <!-- Content at bottom -->
                                        <div class="absolute bottom-0 left-0 right-0 p-5">
                                            <!-- Tag Badge -->
                                            <span class="inline-block px-2.5 py-0.5 bg-gray-800/80 text-white text-[10px] font-bold rounded mb-2.5 uppercase tracking-wide border border-white/20">
                                                Resensi
                                            </span>

                                            <!-- Title & Reviewer -->
                                            <h3 class="text-white text-sm md:text-base font-bold leading-tight line-clamp-2 group-hover:text-emerald-300 transition-colors">
                                                {{ $resensi->title }} / {{ $resensi->reviewer_name }}
                                            </h3>

                                            <!-- Date and Action -->
                                            <div class="flex items-center justify-between mt-2 text-xs text-gray-300">
                                                <span>{{ $resensi->published_at ? $resensi->published_at->format('Y') : $resensi->created_at->format('Y') }}</span>
                                                <span class="text-emerald-400 group-hover:translate-x-1 transition-transform inline-flex items-center gap-1 font-semibold">
                                                    Baca
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Controls Outside -->
                    <button @click="prev()" class="absolute -left-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-white shadow-lg rounded-full flex items-center justify-center text-gray-600 hover:text-emerald-600 hover:scale-110 transition-all z-10 hidden md:flex">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="next()" class="absolute -right-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-white shadow-lg rounded-full flex items-center justify-center text-gray-600 hover:text-emerald-600 hover:scale-110 transition-all z-10 hidden md:flex">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            @endif
        </div>
    </section>

    <!-- Social Media Feed Section -->
    <section class="py-16 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Media Sosial</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Terhubung Dengan Kami</h2>
                <div class="w-24 h-1.5 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Ikuti kegiatan terbaru dan update informasi perpustakaan melalui Instagram kami.</p>
            </div>
            
            <div class="flex justify-center">
                 @if(isset($websiteSettings) && $websiteSettings->instagram_embed_code)
                    <div class="w-full max-w-6xl">
                        {!! $websiteSettings->instagram_embed_code !!}
                    </div>
                 @else
                    <div class="text-center py-12 bg-gray-50 rounded-2xl w-full border border-gray-100 max-w-4xl mx-auto">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-gray-500 italic">Feed Instagram belum dikonfigurasi.</p>
                    </div>
                 @endif
            </div>
        </div>
    </section>

</div>
