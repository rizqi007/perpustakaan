@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
@php
    $contactInfo = \App\Models\ContactInfo::getActive();
@endphp

<div class="min-h-screen bg-white">
    {{-- Header Section --}}
    <section class="py-12 sm:py-16 lg:py-20 bg-white mt-15">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-4 sm:mb-6">
                Hubungi Kami
            </h1>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-12 sm:py-16 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                
                {{-- Contact Form --}}
                <div class="order-2 lg:order-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10">
                        <div class="mb-8">
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">
                                Kirim Pesan
                            </h2>
                            <p class="text-gray-600 leading-relaxed">
                                Isi form di bawah ini dan kami akan merespons dalam 24 jam.
                            </p>
                        </div>

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            {{-- Name Field --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('name') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap Anda"
                                       required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email Field --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('email') border-red-500 @enderror"
                                       placeholder="nama@email.com"
                                       required>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone Field --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('phone') border-red-500 @enderror"
                                       placeholder="08123456789">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Subject Field --}}
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                    Subjek <span class="text-red-500">*</span>
                                </label>
                                <select id="subject" 
                                        name="subject" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('subject') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih subjek</option>
                                    <option value="inquiry" {{ old('subject') == 'inquiry' ? 'selected' : '' }}>Pertanyaan Umum</option>
                                    <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Dukungan Teknis</option>
                                    <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Kerjasama</option>
                                    <option value="complaint" {{ old('subject') == 'complaint' ? 'selected' : '' }}>Keluhan</option>
                                    <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('subject')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Message Field --}}
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pesan <span class="text-red-500">*</span>
                                </label>
                                <textarea id="message" 
                                          name="message" 
                                          rows="6" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 resize-none @error('message') border-red-500 @enderror"
                                          placeholder="Tulis pesan Anda di sini..."
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Privacy Agreement --}}
                            <div class="flex items-start">
                                <input type="checkbox" 
                                       id="privacy" 
                                       name="privacy" 
                                       class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                       required>
                                <label for="privacy" class="ml-2 text-sm text-gray-600">
                                    Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-800 underline">kebijakan privasi</a> dan <a href="#" class="text-blue-600 hover:text-blue-800 underline">syarat & ketentuan</a>.
                                </label>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Kirim Pesan
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="order-1 lg:order-2 space-y-8">
                    {{-- Company Info --}}
                    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">
                            Informasi Kontak
                        </h3>
                        
                        @if($contactInfo)
                        <div class="space-y-6">
                            {{-- Address --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Alamat</h4>
                                    <p class="text-gray-600 leading-relaxed">
                                       {{ $contactInfo->address }}
                                    </p>
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Telepon</h4>
                                    <a href="tel:{{ $contactInfo->phone }}" class="text-gray-600 hover:text-blue-600 transition duration-200">
                                        {{ $contactInfo->phone }}
                                    </a>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Email</h4>
                                    <a href="mailto:{{ $contactInfo->email }}" class="text-gray-600 hover:text-blue-600 transition duration-200">
                                       {{ $contactInfo->email }}
                                    </a>
                                </div>
                            </div>

                            {{-- Working Hours --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Jam Operasional</h4>
                                    <div class="text-gray-600 leading-relaxed">
                                        <p>Senin - Kamis: {{ $contactInfo->monday_thursday }}</p>
                                        <p>Jum'at: {{ $contactInfo->friday }}</p>
                                        <p>Sabtu: {{ $contactInfo->saturday }}</p>
                                        <p>Minggu: {{ $contactInfo->sunday }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-8">Informasi kontak belum tersedia.</p>
                        @endif
                    </div>

                    {{-- Map --}}
                    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">
                            Lokasi Kami
                        </h3>
                        
                        @if($contactInfo && $contactInfo->map_embed_url)
                        <div class="aspect-video rounded-lg overflow-hidden">
                            <iframe 
                                src="{{ $contactInfo->map_embed_url }}" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        @else
                        <div class="aspect-video bg-gray-200 rounded-lg flex items-center justify-center">
                            <p class="text-gray-500 text-center">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Google Maps akan ditampilkan di sini
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Success/Error Messages --}}
@if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            {{ session('error') }}
        </div>
    </div>
@endif

{{-- Auto-hide notifications --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = document.querySelectorAll('.fixed.top-4.right-4');
        notifications.forEach(notification => {
            setTimeout(() => {
                notification.style.transition = 'transform 0.3s ease-in-out';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
        });
    });
</script>
@endsection