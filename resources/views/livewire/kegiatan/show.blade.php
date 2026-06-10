<div class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Top Section: Info (left) + Cover (right) --}}
        <div class="flex flex-col lg:flex-row gap-10 mb-12">

            {{-- Left: Title + Meta Info --}}
            <div class="flex-1 min-w-0">
                {{-- Badge & Date --}}
                <div class="flex items-center gap-3 mb-4">
                    <span class="inline-block px-3 py-1 text-xs font-bold text-emerald-700 bg-emerald-100 border border-emerald-200 rounded-md uppercase tracking-wider">
                        {{ $kegiatan->kategori_label }}
                    </span>
                    <span class="text-sm text-gray-500 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $kegiatan->tanggal_mulai->translatedFormat('d F Y') }}
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-8">{{ $kegiatan->judul }}</h1>

                {{-- Meta Grid (like resensi: judul buku, pengarang, penerbit, tebal) --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 p-5 bg-gray-50 rounded-xl border border-gray-100">
                    <div>
                        <div class="flex items-center gap-1.5 mb-1">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Tanggal</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">{{ $kegiatan->tanggal_mulai->translatedFormat('d M Y') }}</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 mb-1">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Waktu</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">
                            @if($kegiatan->waktu_mulai)
                                {{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') }} WIB
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 mb-1">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Lokasi</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">{{ $kegiatan->lokasi ?? '-' }}</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 mb-1">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Peserta</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">{{ $kegiatan->jumlah_peserta ?? '-' }} orang</p>
                    </div>
                </div>

                {{-- Description (sejajar dengan meta grid, di samping poster) --}}
                @if($kegiatan->deskripsi)
                <div class="mt-8">
                    <div class="prose prose-base max-w-none text-gray-700 leading-relaxed
                        [&>p]:mb-4 [&>p]:leading-relaxed
                        [&>h2]:text-xl [&>h2]:font-bold [&>h2]:text-gray-900 [&>h2]:mt-8 [&>h2]:mb-4
                        [&>h3]:text-lg [&>h3]:font-bold [&>h3]:text-gray-900 [&>h3]:mt-6 [&>h3]:mb-3
                        [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:space-y-2 [&>ul]:mb-4
                        [&>ol]:list-decimal [&>ol]:pl-6 [&>ol]:space-y-2 [&>ol]:mb-4
                        [&>li]:text-gray-700
                        [&>blockquote]:border-l-4 [&>blockquote]:border-emerald-500 [&>blockquote]:pl-4 [&>blockquote]:italic [&>blockquote]:text-gray-600 [&>blockquote]:my-6
                        [&>a]:text-emerald-600 [&>a]:underline
                        [&>strong]:text-gray-900 [&>strong]:font-semibold
                        [&>em]:italic">
                        {!! $kegiatan->deskripsi !!}
                    </div>
                </div>
                @endif
            </div>

            {{-- Right: Cover Poster + Narasumber --}}
            @if($kegiatan->cover_image || ($kegiatan->narasumber && count($kegiatan->narasumber) > 0))
            <div class="lg:w-80 shrink-0">
                <div class="sticky top-24 space-y-6">
                    @if($kegiatan->cover_image)
                    <img src="{{ asset('storage/' . $kegiatan->cover_image) }}" alt="{{ $kegiatan->judul }}" class="w-full h-auto rounded-2xl shadow-xl border border-gray-200 object-cover">
                    @endif

                    {{-- Narasumber under poster --}}
                    @if($kegiatan->narasumber && count($kegiatan->narasumber) > 0)
                    <div class="bg-gray-50 rounded-xl border border-gray-100 p-5">
                        <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Narasumber</h3>
                        <div class="space-y-3">
                            @foreach($kegiatan->narasumber as $speaker)
                                <div class="flex items-center gap-3">
                                    @if(!empty($speaker['foto']))
                                        <img src="{{ asset('storage/' . $speaker['foto']) }}" alt="{{ $speaker['nama'] }}" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-200 shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-sm text-gray-900">{{ $speaker['nama'] }}</p>
                                        @if(!empty($speaker['jabatan']))
                                            <p class="text-[11px] text-gray-500">{{ $speaker['jabatan'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Content Area (same width alignment as meta grid above) --}}
        <div class="flex flex-col lg:flex-row gap-10">
            {{-- Main Content (left, aligned with title/meta) --}}
            <div class="flex-1 min-w-0">
                {{-- Documents & Media --}}
                @if($kegiatan->file_paparan || $kegiatan->file_artikel || $kegiatan->link_rekaman || $kegiatan->link_dokumentasi)
                <div class="mb-10">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 pb-3 border-b border-gray-200">Dokumen & Media</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @if($kegiatan->link_rekaman)
                            <a href="{{ $kegiatan->link_rekaman }}" target="_blank" class="flex items-center gap-4 p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group border border-red-100">
                                <div class="w-11 h-11 bg-red-100 group-hover:bg-red-200 rounded-lg flex items-center justify-center transition shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900">Rekaman Video</p>
                                    <p class="text-xs text-gray-500">Tonton rekaman kegiatan</p>
                                </div>
                            </a>
                        @endif
                        @if($kegiatan->file_paparan)
                            <a href="{{ asset('storage/' . $kegiatan->file_paparan) }}" target="_blank" class="flex items-center gap-4 p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group border border-blue-100">
                                <div class="w-11 h-11 bg-blue-100 group-hover:bg-blue-200 rounded-lg flex items-center justify-center transition shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900">File Paparan</p>
                                    <p class="text-xs text-gray-500">Unduh materi presentasi</p>
                                </div>
                            </a>
                        @endif
                        @if($kegiatan->file_artikel)
                            <a href="{{ asset('storage/' . $kegiatan->file_artikel) }}" target="_blank" class="flex items-center gap-4 p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group border border-purple-100">
                                <div class="w-11 h-11 bg-purple-100 group-hover:bg-purple-200 rounded-lg flex items-center justify-center transition shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900">Artikel / Makalah</p>
                                    <p class="text-xs text-gray-500">Unduh artikel kegiatan</p>
                                </div>
                            </a>
                        @endif
                        @if($kegiatan->link_dokumentasi)
                            <a href="{{ $kegiatan->link_dokumentasi }}" target="_blank" class="flex items-center gap-4 p-4 bg-amber-50 hover:bg-amber-100 rounded-xl transition group border border-amber-100">
                                <div class="w-11 h-11 bg-amber-100 group-hover:bg-amber-200 rounded-lg flex items-center justify-center transition shrink-0">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900">Dokumentasi Foto</p>
                                    <p class="text-xs text-gray-500">Lihat album foto</p>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Gallery --}}
                @if($kegiatan->galeri && count($kegiatan->galeri) > 0)
                <div class="mb-10" x-data="{ open: false, activeImage: 0, images: {{ json_encode(array_map(fn($f) => asset('storage/' . $f), $kegiatan->galeri)) }} }">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 pb-3 border-b border-gray-200">Galeri Foto</h2>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($kegiatan->galeri as $index => $foto)
                            <div class="group relative aspect-square rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer"
                                 @click="open = true; activeImage = {{ $index }}">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Galeri" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border border-white/30 text-white transform scale-90 group-hover:scale-100 transition-transform duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Lightbox Modal --}}
                    <div x-show="open" 
                         class="fixed inset-0 z-50 flex items-center justify-center p-4" 
                         style="display: none;"
                         @keydown.window.escape="open = false"
                         @keydown.window.arrow-left="activeImage = (activeImage === 0) ? images.length - 1 : activeImage - 1"
                         @keydown.window.arrow-right="activeImage = (activeImage === images.length - 1) ? 0 : activeImage + 1">
                        
                        <!-- Backdrop -->
                        <div class="absolute inset-0 bg-black/90 backdrop-blur-md transition-opacity" 
                             @click="open = false"
                             x-show="open"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"></div>

                        <!-- Content wrapper -->
                        <div class="relative z-10 max-w-5xl w-full flex flex-col items-center justify-center"
                             x-show="open"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95">
                            
                            <!-- Close Button -->
                            <button @click="open = false" class="absolute -top-14 right-0 p-2 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full border border-white/10 transition-colors z-20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>

                            <!-- Navigation Left -->
                            <button @click="activeImage = (activeImage === 0) ? images.length - 1 : activeImage - 1" 
                                    class="absolute left-4 top-1/2 -translate-y-1/2 p-3 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full border border-white/10 transition-all hover:scale-110 z-20"
                                    x-show="images.length > 1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>

                            <!-- Navigation Right -->
                            <button @click="activeImage = (activeImage === images.length - 1) ? 0 : activeImage + 1" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 p-3 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full border border-white/10 transition-all hover:scale-110 z-20"
                                    x-show="images.length > 1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>

                            <!-- Image Display -->
                            <div class="relative bg-black rounded-2xl overflow-hidden shadow-2xl max-h-[80vh] w-full flex items-center justify-center border border-white/10">
                                <img :src="images[activeImage]" class="max-h-[80vh] max-w-full object-contain mx-auto select-none">
                            </div>

                            <!-- Counter -->
                            <div class="mt-4 px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/10 rounded-full text-white/90 text-sm font-semibold">
                                <span x-text="activeImage + 1"></span> / <span x-text="images.length"></span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>


    </div>
</div>
