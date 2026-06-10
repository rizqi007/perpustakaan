{{-- Menggunakan layout utama dari app.blade.php --}}
@extends('layouts.app')

{{-- Mendefinisikan konten untuk bagian 'content' di layout --}}
@section('content')

<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-28 md:pt-10 md:mt-20">

        {{-- Judul Halaman --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800">Berita</h1>
            <p class="text-gray-600 mt-2">Kumpulan berita dan informasi terkini dari Perpustakaan Kementerian Agama RI.</p>
        </div>

        {{-- Grid untuk menampilkan semua berita --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($beritas as $item)
                <div class="bg-white rounded-lg shadow-md overflow-hidden group flex flex-col">
                    <a href="{{ route('berita.show', $item) }}" class="block">
                        <div class="relative">
                            {{-- Gambar Berita --}}
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        {{-- Judul Berita --}}
                        <h3 class="font-bold text-xl mb-2 text-gray-800">
                            <a href="{{ route('berita.show', $item) }}" class="hover:text-blue-600">{{ $item->title }}</a>
                        </h3>
                        {{-- Tanggal Publikasi --}}
                      <div class="flex items-center text-xs text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <time datetime="{{ $item->published_at->format('Y-m-d') }}">
                                {{ $item->published_at->format('d F Y') }}
                            </time>
                        </div>
                        {{-- Ringkasan Konten --}}
                        <div class="text-gray-700 mb-4 flex-grow">
                            {!! \Illuminate\Support\Str::limit(strip_tags($item->content), 100) !!}
                        </div>
                        {{-- Link ke Halaman Detail --}}
                    </div>
                </div>
            @empty
                {{-- Pesan jika tidak ada berita --}}
                <p class="col-span-full text-center text-gray-500 text-lg">
                    Saat ini belum ada berita yang dipublikasikan.
                </p>
            @endforelse
        </div>

        {{-- Link Paginasi --}}
        <div class="mt-12">
            {{ $beritas->links() }}
        </div>

    </div>
</div>

@endsection
