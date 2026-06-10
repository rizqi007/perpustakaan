{{-- 
    File: resources/views/tentang/profil.blade.php
    Deskripsi: Halaman untuk menampilkan profil perpustakaan dengan layout card yang minimalis.
--}}

@extends('layouts.app')

@section('title', 'Profil Perpustakaan')

@section('content')
@php
    // Sebaiknya di-controller, tapi untuk cepatnya tetap di sini
    /** @var \App\Models\LibraryProfile|null $profile */
    $profile = App\Models\LibraryProfile::query()->first();

    // Helper aman untuk array JSON agar tidak error ketika null
    $misi        = (array) data_get($profile, 'misi', []);
    $functions   = (array) data_get($profile, 'functions', []);
    $tasks       = (array) data_get($profile, 'tasks', []);
    $legalBases  = (array) data_get($profile, 'legal_bases', []);
    $milestones  = (array) data_get($profile, 'milestones', []);
    $collections = (array) data_get($profile, 'collections', []);
@endphp

<div class="bg-gray-50 py-12 sm:py-16">
    <div class="mx-auto max-w-6xl px-4 lg:px-6 mt-10">

        {{-- Header Section --}}
        <div class="text-center mb-10">
            {{-- <div class="inline-block bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm font-medium mb-3">
                Profil Perpustakaan
            </div> --}}
            <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-3 mt-20">
                Profil Perpustakaan Kementerian Agama
            </h1>

            @if($profile && $profile->tagline)
                <p class="mx-auto max-w-2xl text-base text-gray-600 text-center">
                    {{ $profile->tagline }}
                </p>
            @else
                <p class="mx-auto max-w-2xl text-base text-gray-600 text-justify">
                    Mewujudkan masyarakat literat keagamaan yang mampu bersikap moderat dalam kehidupan berbangsa dan bernegara
                </p>
            @endif
        </div>

        {{-- Hero Image --}}
        <div class="mb-12">
            <div class="relative overflow-hidden rounded-xl shadow-md">
                <img 
                    class="w-full h-[350px] object-cover" 
                    src="{{ asset('images/gedung.jpg') }}" 
                    alt="Gedung Perpustakaan Kementerian Agama">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 to-transparent"></div>
            </div>
        </div>

        @if($profile)
            {{-- Visi & Misi Cards --}}
            <div class="grid md:grid-cols-2 gap-6 mb-12">
                {{-- Visi --}}
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                    <div class="p-5">
                        <div class="flex items-center mb-3">
                            <div class="bg-green-50 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Visi</h3>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed text-justify">{{ $profile->visi }}</p>
                    </div>
                </div>
                
                {{-- Misi --}}
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                    <div class="p-5">
                        <div class="flex items-center mb-3">
                            <div class="bg-green-50 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Misi</h3>
                        </div>
                        @if(count($misi))
                            <ul class="space-y-2">
                                @foreach($misi as $index => $item)
                                    <li class="flex items-start text-sm">
                                        <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center bg-green-600 text-white rounded text-xs font-medium mr-2 mt-0.5">
                                            {{ $index + 1 }}
                                        </span>
                                        <span class="text-gray-600 text-justify">{{ data_get($item, 'item') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 text-sm text-justify">Belum ada data misi.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Fungsi Perpustakaan --}}
            @if(count($functions))
                <div class="mb-12">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Fungsi Perpustakaan</h2>
                        <div class="w-16 h-0.5 bg-green-600 mx-auto"></div>
                    </div>

                    @if(count($functions) === 1)
                        <div class="max-w-3xl mx-auto">
                            @foreach($functions as $index => $function)
                                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                                    <div class="p-5">
                                        <div class="flex items-center gap-4 mb-3">
                                            <div class="bg-green-50 w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <span class="text-xl font-semibold text-green-600">{{ $index + 1 }}</span>
                                            </div>
                                            <h4 class="text-lg font-semibold text-gray-900">{{ data_get($function, 'title') }}</h4>
                                        </div>
                                        <div class="text-gray-600 text-sm leading-relaxed text-justify pl-16">
                                            {!! data_get($function, 'description') !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="grid md:grid-cols-3 gap-4">
                            @foreach($functions as $index => $function)
                                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                                    <div class="p-4">
                                        <div class="bg-green-50 w-10 h-10 rounded-lg flex items-center justify-center mb-3">
                                            <span class="text-lg font-semibold text-green-600">{{ $index + 1 }}</span>
                                        </div>
                                        <h4 class="text-base font-semibold text-gray-900 mb-2">{{ data_get($function, 'title') }}</h4>
                                        <div class="text-gray-600 text-sm leading-relaxed text-justify">
                                            {!! data_get($function, 'description') !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- Tugas Perpustakaan --}}
            @if(count($tasks))
                <div class="mb-12">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Tugas Perpustakaan Kemenag</h2>
                        <div class="w-16 h-0.5 bg-green-600 mx-auto"></div>
                    </div>

                    @if(count($tasks) === 1)
                        <div class="max-w-3xl mx-auto">
                            @foreach($tasks as $index => $task)
                                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100 p-5">
                                    <div class="flex items-start gap-4 mb-3">
                                        <div class="bg-green-600 text-white w-10 h-10 rounded-lg flex items-center justify-center font-semibold text-lg flex-shrink-0">
                                            {{ $index + 1 }}
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900 pt-1">{{ data_get($task, 'title') }}</h4>
                                    </div>
                                    <div class="text-gray-600 text-sm leading-relaxed text-justify pl-14">
                                        {!! data_get($task, 'description') !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($tasks as $index => $task)
                                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100 p-4">
                                    <div class="flex items-start mb-2">
                                        <div class="bg-green-600 text-white w-7 h-7 rounded-lg flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                            {{ $index + 1 }}
                                        </div>
                                        <h4 class="ml-3 text-base font-semibold text-gray-900">{{ data_get($task, 'title') }}</h4>
                                    </div>
                                    <div class="text-gray-600 text-sm leading-relaxed text-justify ml-10">
                                        {!! data_get($task, 'description') !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- Dasar Hukum --}}
            @if(count($legalBases))
                <div class="mb-12">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Dasar Hukum</h2>
                        <div class="w-16 h-0.5 bg-green-600 mx-auto"></div>
                    </div>

                    @if(count($legalBases) === 1)
                        <div class="max-w-3xl mx-auto">
                            @foreach($legalBases as $legal)
                                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100 overflow-hidden">
                                    <div class="bg-green-600 p-5 text-white">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold mb-1">{{ data_get($legal, 'title') }}</h4>
                                                @if(data_get($legal, 'document_number'))
                                                    <p class="text-green-100 text-sm">{{ data_get($legal, 'document_number') }}</p>
                                                @endif
                                            </div>
                                            @if(data_get($legal, 'date'))
                                                <div class="bg-white/20 px-3 py-1 rounded text-sm font-medium">
                                                    {{ \Illuminate\Support\Carbon::parse(data_get($legal, 'date'))->format('Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-5">
                                       <p class="text-gray-600 text-sm leading-relaxed text-justify mb-3">
                                            {{ data_get($legal, 'description') }}
                                        </p>
                                        @if(data_get($legal, 'file_path'))
                                            <a href="{{ Storage::url(data_get($legal, 'file_path')) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition-colors">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Download
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($legalBases as $legal)
                                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100 overflow-hidden">
                                    <div class="bg-green-600 p-4 text-white">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h4 class="text-base font-semibold mb-1">{{ data_get($legal, 'title') }}</h4>
                                                @if(data_get($legal, 'document_number'))
                                                    <p class="text-green-100 text-sm">{{ data_get($legal, 'document_number') }}</p>
                                                @endif
                                            </div>
                                            @if(data_get($legal, 'date'))
                                                <div class="bg-white/20 px-2 py-1 rounded text-xs font-medium">
                                                    {{ \Illuminate\Support\Carbon::parse(data_get($legal, 'date'))->format('Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <p class="text-gray-600 text-sm leading-relaxed text-justify mb-3">{{ data_get($legal, 'description') }}</p>
                                        @if(data_get($legal, 'file_path'))
                                            <a href="{{ Storage::url(data_get($legal, 'file_path')) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition-colors">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Download
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- Milestone Timeline --}}
            @if(count($milestones))
                <div class="mb-12">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Milestone Perpustakaan</h2>
                        <div class="w-16 h-0.5 bg-green-600 mx-auto"></div>
                    </div>
                    
                    <div class="relative max-w-4xl mx-auto">
                        <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-green-200"></div>
                        <div class="space-y-8">
                            @foreach($milestones as $milestone)
                                <div class="relative flex gap-6">
                                    <div class="relative z-10 flex-shrink-0">
                                        <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center shadow-md">
                                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100 p-4 mb-4">
                                        <div class="flex flex-col md:flex-row gap-4">
                                            @if(data_get($milestone, 'image_path'))
                                                <div class="md:w-48 flex-shrink-0">
                                                    <img src="{{ Storage::url(data_get($milestone, 'image_path')) }}" 
                                                         alt="{{ data_get($milestone, 'title') }}" 
                                                         class="w-full h-32 object-cover rounded-lg">
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                @if(data_get($milestone, 'year'))
                                                    <div class="bg-green-600 text-white px-3 py-1 rounded inline-block text-sm font-semibold mb-2">
                                                        {{ data_get($milestone, 'year') }}
                                                    </div>
                                                @endif
                                                <h4 class="text-base font-semibold text-gray-900 mb-1">{{ data_get($milestone, 'title') }}</h4>
                                                <p class="text-gray-600 text-sm text-justify">{{ data_get($milestone, 'description') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Koleksi Perpustakaan --}}
            @if(count($collections))
                <div class="mb-12">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Koleksi Perpustakaan</h2>
                        <div class="w-16 h-0.5 bg-green-600 mx-auto"></div>
                    </div>

                    @if(count($collections) === 1)
                        <div class="max-w-3xl mx-auto mb-8">
                            @foreach($collections as $collection)
                                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100 overflow-hidden">
                                    <div class="flex flex-col md:flex-row">
                                        @if(data_get($collection, 'cover_image'))
                                            <div class="md:w-64 h-48 md:h-auto overflow-hidden flex-shrink-0">
                                                <img src="{{ Storage::url(data_get($collection, 'cover_image')) }}" 
                                                     alt="{{ data_get($collection, 'title') }}" 
                                                     class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="md:w-64 h-48 md:h-auto bg-green-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-16 h-16 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="p-5 flex-1">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-sm font-medium text-green-600 bg-green-50 px-3 py-1 rounded">
                                                    {{ data_get($collection, 'category') }}
                                                </span>
                                                <span class="text-lg font-bold text-green-600">
                                                    {{ number_format((int) data_get($collection, 'quantity', 0)) }}
                                                </span>
                                            </div>
                                            <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ data_get($collection, 'title') }}</h4>
                                            @if(data_get($collection, 'description'))
                                                <p class="text-gray-600 text-sm leading-relaxed text-justify">{{ data_get($collection, 'description') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="grid md:grid-cols-3 gap-4 mb-8">
                            @foreach($collections as $collection)
                                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100 overflow-hidden">
                                    @if(data_get($collection, 'cover_image'))
                                        <div class="h-32 overflow-hidden">
                                            <img src="{{ Storage::url(data_get($collection, 'cover_image')) }}" 
                                                 alt="{{ data_get($collection, 'title') }}" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="h-32 bg-green-100 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded">
                                                {{ data_get($collection, 'category') }}
                                            </span>
                                            <span class="text-sm font-semibold text-green-600">
                                                {{ number_format((int) data_get($collection, 'quantity', 0)) }}
                                            </span>
                                        </div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ data_get($collection, 'title') }}</h4>
                                        @if(data_get($collection, 'description'))
                                            <p class="text-gray-600 text-xs text-justify line-clamp-2">{{ data_get($collection, 'description') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Total Koleksi --}}
                    <div class="flex justify-center">
                        <div class="bg-green-600 rounded-lg shadow-md p-6 text-center text-white max-w-sm w-full">
                            <div class="text-xs font-medium text-green-100 mb-2">Total Koleksi</div>
                            <p class="text-4xl font-bold mb-1">
                                {{ number_format(collect($collections)->sum(fn($c) => (int) data_get($c, 'quantity', 0))) }}
                            </p>
                            <p class="text-sm text-green-100">Item Tersedia</p>
                        </div>
                    </div>
                </div>
            @endif

        @else
            {{-- Fallback Design --}}
            <div class="grid md:grid-cols-2 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center mb-3">
                        <div class="bg-green-50 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Visi</h3>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed text-justify">
                        Memperkuat literasi keluarga besar Kementerian Agama dan masyarakat pada umumnya dalam hal moderasi beragama melalui penyediaan bahan bacaan yang berkualitas dan penumbuhan budaya baca.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center mb-3">
                        <div class="bg-green-50 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Misi</h3>
                    </div>
                    <ul class="space-y-2">
                        <li class="flex items-start text-sm">
                            <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center bg-green-600 text-white rounded text-xs font-medium mr-2">1</span>
                            <span class="text-gray-600 text-justify">Menyediakan referensi yang lengkap untuk penelitian dan kajian sosial keagamaan</span>
                        </li>
                        <li class="flex items-start text-sm">
                            <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center bg-green-600 text-white rounded text-xs font-medium mr-2">2</span>
                            <span class="text-gray-600 text-justify">Menyediakan ruang yang kondusif untuk membaca dan berdiskusi</span>
                        </li>
                        <li class="flex items-start text-sm">
                            <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center bg-green-600 text-white rounded text-xs font-medium mr-2">3</span>
                            <span class="text-gray-600 text-justify">Membantu publikasi hasil-hasil penelitian Kementerian Agama</span>
                        </li>
                        <li class="flex items-start text-sm">
                            <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center bg-green-600 text-white rounded text-xs font-medium mr-2">4</span>
                            <span class="text-gray-600 text-justify">Membangun kerjasama dan kolaborasi dengan lembaga-lembaga penyedia referensi</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Admin Notice --}}
            <div class="flex justify-center">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg shadow-sm p-6 text-center max-w-2xl">
                    <div class="inline-block bg-yellow-100 p-3 rounded-full mb-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Data Profil Lengkap Belum Tersedia</h3>
                    <p class="text-gray-600 text-sm">
                        Silakan lengkapi data profil melalui dashboard admin untuk menampilkan informasi lengkap perpustakaan
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
