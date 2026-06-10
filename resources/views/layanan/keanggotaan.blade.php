{{-- 
    File: resources/views/layanan/keanggotaan.blade.php
    Deskripsi: Halaman untuk informasi dan pendaftaran keanggotaan perpustakaan.
--}}

@extends('layouts.app')

@section('title', 'Keanggotaan Perpustakaan')

@section('content')
<div class="bg-gray-50 py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        {{-- Header Halaman --}}
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Keanggotaan Perpustakaan</h2>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                Bergabunglah dengan kami dan dapatkan akses penuh ke ribuan koleksi pengetahuan. Pendaftaran anggota gratis dan terbuka untuk umum.
            </p>
        </div>

        {{-- Konten Utama --}}
        <div class="mx-auto mt-16 grid max-w-7xl grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-2">
            
            {{-- Kolom Kiri: Syarat dan Manfaat --}}
            <div class="flex flex-col">
                <div class="bg-white p-8 rounded-2xl shadow-md">
                    <h3 class="text-2xl font-semibold leading-9 tracking-tight text-gray-900">Manfaat Keanggotaan</h3>
                    <ul class="mt-6 space-y-3 text-base leading-7 text-gray-600 list-disc pl-5">
                        <li>Akses peminjaman koleksi buku fisik.</li>
                        <li>Akses ke koleksi digital dan e-journal yang kami langgan.</li>
                        <li>Prioritas dalam mengikuti acara dan workshop yang kami selenggarakan.</li>
                        <li>Fasilitas ruang baca dan diskusi yang nyaman.</li>
                    </ul>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-md mt-8">
                    <h3 class="text-2xl font-semibold leading-9 tracking-tight text-gray-900">Syarat Pendaftaran</h3>
                    <ul class="mt-6 space-y-3 text-base leading-7 text-gray-600 list-disc pl-5">
                        <li>Mengisi formulir pendaftaran secara online atau offline.</li>
                        <li>Menyerahkan fotokopi kartu identitas (KTP/Kartu Pelajar/SIM) yang masih berlaku.</li>
                        <li>Menyerahkan pas foto berwarna ukuran 3x4 sebanyak 1 lembar.</li>
                        <li>Bersedia mematuhi segala peraturan dan tata tertib yang berlaku di perpustakaan.</li>
                    </ul>
                </div>
            </div>

            {{-- Kolom Kanan: Formulir Pendaftaran --}}
            <div class="bg-white p-8 rounded-2xl shadow-md">
                <h3 class="text-2xl font-semibold leading-9 tracking-tight text-gray-900">Formulir Pendaftaran Online</h3>
                <form action="#" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap</label>
                        <div class="mt-2">
                            <input type="text" name="nama_lengkap" id="nama_lengkap" autocomplete="name" class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Alamat Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="nomor_telepon" class="block text-sm font-medium leading-6 text-gray-900">Nomor Telepon</label>
                        <div class="mt-2">
                            <input type="tel" name="nomor_telepon" id="nomor_telepon" autocomplete="tel" class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="alamat" class="block text-sm font-medium leading-6 text-gray-900">Alamat Lengkap</p>
                        <div class="mt-2">
                            <textarea name="alamat" id="alamat" rows="4" class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="flex w-full justify-center rounded-md bg-green-600 px-3 py-2.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
