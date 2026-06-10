{{-- 
    File: resources/views/layanan/katalog-online.blade.php
    Deskripsi: Halaman untuk pencarian koleksi buku di katalog online.
--}}

@extends('layouts.app')

@section('title', 'Katalog Online')

@section('content')
<div class="bg-white py-16 sm:py-24 mt-10">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        {{-- Header Halaman --}}
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Katalog Online</h2>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                Temukan koleksi yang Anda cari melalui sistem pencarian kami yang canggih. Jelajahi ribuan judul buku, jurnal, dan karya ilmiah.
            </p>
        </div>

        {{-- Bar Pencarian Utama --}}
        <div class="mt-16 mx-auto max-w-3xl">
            <form action="#" method="GET" class="flex items-center gap-x-3">
                <div class="relative flex-grow">
                    <input type="search" name="q" id="q" class="block w-full rounded-full border-0 py-3 px-6 text-gray-900 shadow-md ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6" placeholder="Masukkan judul, pengarang, atau subjek...">
                    <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                        <kbd class="inline-flex items-center rounded border border-gray-200 px-1 font-sans text-xs text-gray-400">⌘K</kbd>
                    </div>
                </div>
                <button type="submit" class="rounded-full bg-green-600 p-3 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Hasil Pencarian (Contoh) --}}
        <div class="mt-16 border-t border-gray-200 pt-10 mx-auto max-w-5xl">
            <div class="text-center">
                <h3 class="text-xl font-semibold text-gray-800">Hasil Pencarian untuk "Sejarah Islam"</h3>
                <p class="text-sm text-gray-500 mt-1">Menampilkan 3 dari 125 hasil.</p>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                @for ($i = 0; $i < 3; $i++)
                <div class="group relative">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                        <img src="https://placehold.co/400x600/e2e8f0/334155?text=Cover+Buku" alt="Cover buku placeholder" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h4 class="text-sm text-gray-700">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    Judul Buku Placeholder {{ $i + 1 }}
                                </a>
                            </h4>
                            <p class="mt-1 text-sm text-gray-500">Nama Pengarang</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900">202{{ $i }}</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection
