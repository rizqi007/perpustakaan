<div class="min-h-screen bg-gray-50">
    {{-- Hero --}}
    <div class="bg-emerald-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-emerald-200 mb-4">
                <a href="{{ route('landing') }}" class="hover:text-white transition-colors">Beranda</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('katalog.index') }}" class="hover:text-white transition-colors">Katalog Buku</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white font-medium truncate max-w-xs">{{ Str::limit($book->judul_penanggung_jawab, 40) }}</span>
            </nav>
            <h1 class="text-2xl md:text-4xl font-bold">Detail Buku</h1>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex flex-col md:flex-row">
                {{-- Cover --}}
                <div class="w-full md:w-1/3 bg-gray-50 flex items-center justify-center p-8 border-b md:border-b-0 md:border-r border-gray-100">
                    @php
                        $coverPath = $book->cover ?? null;
                        $isImage = $coverPath && preg_match('/\.(jpg|jpeg|png|webp|gif|avif)$/i', $coverPath);
                    @endphp

                    @if($isImage)
                        <img src="{{ asset('storage/' . $coverPath) }}" alt="{{ $book->judul_penanggung_jawab }}" class="max-w-full max-h-[400px] object-contain rounded-lg shadow-lg">
                    @else
                        <div class="w-48 h-64 bg-gradient-to-br from-emerald-50 to-teal-100 rounded-lg flex flex-col items-center justify-center shadow-lg">
                            <svg class="w-16 h-16 text-emerald-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-sm text-emerald-400 font-medium">Tidak ada cover</span>
                        </div>
                    @endif
                </div>

                {{-- Detail --}}
                <div class="w-full md:w-2/3 p-6 md:p-10">
                    @if($book->identifikasi)
                        <span class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full mb-4 uppercase tracking-wider">ISBN: {{ $book->identifikasi }}</span>
                    @endif

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 leading-tight">
                        {{ Str::title($book->judul_penanggung_jawab) }}
                    </h2>

                    <div class="space-y-3 mb-6">
                        @if($book->edisi)
                            <div class="flex items-start gap-3">
                                <span class="text-sm font-semibold text-gray-500 w-32 shrink-0">Edisi</span>
                                <span class="text-sm text-gray-800">{{ $book->edisi }}</span>
                            </div>
                        @endif
                        @if($book->publikasi)
                            <div class="flex items-start gap-3">
                                <span class="text-sm font-semibold text-gray-500 w-32 shrink-0">Publikasi</span>
                                <span class="text-sm text-gray-800">{{ $book->publikasi }}</span>
                            </div>
                        @endif
                        @if($book->deskripsi_fisik)
                            <div class="flex items-start gap-3">
                                <span class="text-sm font-semibold text-gray-500 w-32 shrink-0">Deskripsi Fisik</span>
                                <span class="text-sm text-gray-800">{{ $book->deskripsi_fisik }}</span>
                            </div>
                        @endif
                        @if($book->subjek)
                            <div class="flex items-start gap-3">
                                <span class="text-sm font-semibold text-gray-500 w-32 shrink-0">Subjek</span>
                                <span class="text-sm text-gray-800">{{ $book->subjek }}</span>
                            </div>
                        @endif
                        @if($book->klasifikasi)
                            <div class="flex items-start gap-3">
                                <span class="text-sm font-semibold text-gray-500 w-32 shrink-0">Klasifikasi</span>
                                <span class="text-sm text-gray-800">{{ $book->klasifikasi }}</span>
                            </div>
                        @endif
                    </div>

                    @if($book->sinopsis)
                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Sinopsis</h3>
                            <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $book->sinopsis }}</p>
                        </div>
                    @endif

                    <div class="mt-8">
                        <a href="{{ route('katalog.index') }}" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            Kembali ke Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
