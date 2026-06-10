<div>
    @if($form)
        @php
            $isDashboard = ($slug === 'pengajuan-isbn');
        @endphp

        @if(!$isDashboard)
            {{-- Hero Header Section --}}
            <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-emerald-900 pt-32 pb-16 md:pb-20 overflow-hidden"
                @if($form->cover_image) style="background-image: linear-gradient(to bottom, rgba(17, 24, 39, 0.8), rgba(6, 78, 59, 0.9)), url('{{ Storage::url($form->cover_image) }}'); background-size: cover; background-position: center;" @endif>
                
                {{-- Decorative Elements --}}
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-10 left-10 w-72 h-72 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"></div>
                    <div class="absolute bottom-10 right-10 w-72 h-72 bg-teal-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
                </div>

                <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                    {{-- Breadcrumb --}}
                    <nav class="flex justify-center items-center space-x-2 text-sm text-gray-300 mb-6">
                        <a href="{{ route('landing') }}" class="hover:text-emerald-300 transition">Beranda</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <span class="text-emerald-300">Formulir</span>
                    </nav>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                        {{ $form->title }}
                    </h1>

                    <div class="mt-6 flex flex-wrap justify-center gap-3 text-sm">
                        @if($form->start_date || $form->end_date)
                            <div class="flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20">
                                <svg class="w-4 h-4 mr-2 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Periode: 
                                    @if($form->start_date) {{ $form->start_date->format('d M Y') }} @endif 
                                    @if($form->end_date) s/d {{ $form->end_date->format('d M Y') }} @endif
                                </span>
                            </div>
                        @endif

                        @if($form->max_quota)
                            @php
                                $submissionsCount = $form->submissions()->count();
                                $remainingQuota = max(0, $form->max_quota - $submissionsCount);
                            @endphp
                            <div class="flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20">
                                <svg class="w-4 h-4 mr-2 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span>Sisa Kuota: <strong>{{ $remainingQuota }} / {{ $form->max_quota }}</strong> Peserta</span>
                            </div>
                        @else
                            <div class="flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20">
                                <svg class="w-4 h-4 mr-2 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Akses Terbuka & Bebas Kuota</span>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @else
            {{-- Header Section for Dashboard --}}
            <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6 px-4 sm:px-0">
                    <div>
                        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200">{{ $form->title }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Silakan lengkapi formulir pengajuan di bawah ini</p>
                    </div>
                    <!-- <a href="{{ route('isbn.index') }}" 
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold text-xs uppercase tracking-widest transition-all shadow-md">
                        &larr; Riwayat Pengajuan
                    </a> -->
                </div>
            </div>
        @endif

        {{-- Main Content: Two Column Layout --}}
        <section class="{{ $isDashboard ? 'pb-16 max-w-7xl mx-auto sm:px-6 lg:px-8' : 'relative -mt-8 pb-16' }}">
            <div class="{{ $isDashboard ? 'px-4 sm:px-0' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8' }}">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- LEFT COLUMN: Information Sidebar --}}
                    <div class="lg:col-span-3 space-y-6">
                        {{-- Description Card --}}
                        @if($form->description)
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 relative overflow-hidden sticky top-28">
                                {{-- Accent bar --}}
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>

                                <div class="flex items-center gap-3 mb-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 dark:bg-emerald-900/50 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white uppercase tracking-wider">Informasi</h3>
                                </div>

                                @if(strip_tags($form->description) !== $form->description)
                                    <div class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{!! $form->description !!}</div>
                                @else
                                    <div class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed whitespace-pre-line">{{ $form->description }}</div>
                                @endif

                                {{-- Quick Info Cards --}}
                                <div class="mt-6 pt-5 border-t border-gray-100 dark:border-gray-700 space-y-3">
                                    <div class="flex items-center gap-3 text-sm">
                                        <div class="flex-shrink-0 w-8 h-8 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </div>
                                        <span class="text-gray-600 dark:text-gray-400">Login sebagai: <strong class="text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</strong></span>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm">
                                        <div class="flex-shrink-0 w-8 h-8 bg-amber-50 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        </div>
                                        <span class="text-gray-600 dark:text-gray-400">Total pengiriman Anda: <strong class="text-gray-800 dark:text-gray-200">{{ count($mySubmissions) }}</strong></span>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm">
                                        <div class="flex-shrink-0 w-8 h-8 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        </div>
                                        <span class="text-gray-600 dark:text-gray-400">Data Anda aman & terlindungi</span>
                                    </div>
 
                                    {{-- Guidebook Download --}}
                                    @if($form->guidebook_path)
                                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 mt-2">
                                            <a href="{{ Storage::url($form->guidebook_path) }}" target="_blank" class="flex items-center gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl hover:bg-emerald-100 dark:hover:bg-emerald-900/40 transition group">
                                                <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 dark:bg-emerald-800 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-300">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-emerald-700 dark:group-hover:text-emerald-200 transition">Download Panduan</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF, Panduan Pengisian</p>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- RIGHT COLUMN: Form + Submissions --}}
                    <div class="lg:col-span-9 space-y-6">

                        {{-- Success Message --}}
                        @if($successMessage)
                            <div class="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 rounded-2xl p-5 flex items-start gap-4" role="alert">
                                <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 dark:bg-emerald-800 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-emerald-800 dark:text-emerald-300">Berhasil!</p>
                                    <p class="text-sm text-emerald-700 dark:text-emerald-400">{{ $successMessage }}</p>
                                    <button wire:click="toggleForm" class="mt-3 inline-flex items-center text-sm font-semibold text-emerald-700 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Isi Formulir Baru
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Tab Buttons --}}
                        @if(!$isDashboard && count($mySubmissions) > 0)
                            <div class="flex bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-1 gap-1">
                                <button wire:click="$set('showForm', true)"
                                    class="flex-1 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2
                                        {{ $showForm ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Isi Formulir Baru
                                </button>
                                <button wire:click="$set('showForm', false)"
                                    class="flex-1 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2
                                        {{ !$showForm ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Riwayat Saya ({{ count($mySubmissions) }})
                                </button>
                            </div>
                        @endif

                        {{-- Date Validation Alert --}}
                        @if(!$isDateValid)
                            <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 rounded-2xl p-5 flex items-start gap-4" role="alert">
                                <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 dark:bg-yellow-800 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-yellow-800 dark:text-yellow-300">Pendaftaran Tidak Tersedia</p>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-400">{{ $dateMessage }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Quota Full Alert --}}
                        @if($isQuotaFull)
                            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-2xl p-5 flex items-start gap-4" role="alert">
                                <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-800 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-red-800 dark:text-red-300">Kuota Penuh</p>
                                    <p class="text-sm text-red-700 dark:text-red-400">Mohon maaf, kuota pendaftaran untuk formulir ini sudah terpenuhi.</p>
                                </div>
                            </div>
                        @endif

                        {{-- FORM CARD --}}
                        @if($showForm)
                            {{-- Revision Mode Banner --}}
                            @if($revisionMode)
                                <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl p-5 flex items-start gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-emerald-800">Mode Perbaikan</p>
                                        <p class="text-sm text-emerald-700">Anda sedang memperbaiki pengajuan. Data lama telah diisi secara otomatis.</p>
                                        <button type="button" wire:click="toggleForm" class="mt-2 text-xs font-semibold text-emerald-600 hover:text-emerald-800 underline">Batalkan Perbaikan</button>
                                    </div>
                                </div>
                            @endif

                             @if($slug === 'pengajuan-isbn')
                                 @include('livewire.front.isbn-form-custom')
                             @else
                                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                                {{-- Card Header --}}
                                <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-6 md:px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h2 class="text-lg font-bold text-white">Isi Formulir</h2>
                                            <p class="text-sm text-emerald-100">Lengkapi semua kolom yang ditandai <span class="text-yellow-300">*</span></p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Body --}}
                                <form wire:submit.prevent="submit" class="p-6 md:p-8">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @foreach($form->fields as $index => $field)
                                            @php
                                                $isFullWidth = in_array($field['type'], ['textarea', 'file']) || ($form->time_slot_label && $field['label'] === $form->time_slot_label) || strlen($field['helper_text'] ?? '') > 100;
                                            @endphp
                                            <div wire:key="field-{{ $index }}" class="{{ $isFullWidth ? 'md:col-span-2' : '' }}">
                                                <label class="block mb-2">
                                                    <div class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400 text-xs font-bold mr-2">
                                                            {{ $index + 1 }}
                                                        </span>
                                                        {{ $field['label'] }}
                                                        @if($field['required'])
                                                            <span class="text-red-500 ml-1">*</span>
                                                        @endif
                                                    </div>
                                                </label>

                                                @if($field['type'] === 'textarea')
                                                    <textarea
                                                        wire:model="data.{{ $field['label'] }}"
                                                        rows="4"
                                                        placeholder="Masukkan {{ strtolower($field['label']) }}..."
                                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 text-sm resize-none"
                                                    ></textarea>
                                                @elseif($field['type'] === 'select' && $form->time_slot_label && $field['label'] === $form->time_slot_label)
                                                    @php 
                                                        $fieldKey = $field['label']; 
                                                        $fieldId = 'field-input-' . $index; 
                                                        $selectedDate = $this->data[$form->booking_date_label] ?? null;
                                                        $sessionQuotas = $selectedDate ? $this->getSessionQuotas() : [];
                                                    @endphp
                                                    
                                                    {{-- Hidden Input for Livewire Binding --}}
                                                    <input type="hidden" id="{{ $fieldId }}" wire:model="data.{{ $fieldKey }}">

                                                    @if(!$selectedDate)
                                                        {{-- Date not selected state --}}
                                                        <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-dashed border-amber-200 dark:border-amber-700/50 rounded-2xl flex items-center gap-3 text-amber-800 dark:text-amber-300 text-sm">
                                                            <svg class="w-5 h-5 shrink-0 text-amber-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                            <span>Silakan pilih <strong>{{ $form->booking_date_label }}</strong> terlebih dahulu untuk melihat ketersediaan sesi.</span>
                                                        </div>
                                                    @else
                                                        {{-- Session Cards Grid --}}
                                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" x-data="{ 
                                                            selectedSession: @entangle('data.' . $fieldKey),
                                                            selectSession(val, isFull) {
                                                                if (isFull) return;
                                                                this.selectedSession = val;
                                                            }
                                                        }">
                                                            @foreach($sessionQuotas as $session)
                                                                @php
                                                                    $isFull = $session['is_full'];
                                                                    $val = $session['value'];
                                                                    $lbl = $session['label'];
                                                                    $rem = $session['remaining'];
                                                                    $max = $form->max_quota;
                                                                @endphp
                                                                <button type="button" 
                                                                    @click="selectSession('{{ $val }}', {{ $isFull ? 'true' : 'false' }})"
                                                                    class="relative text-left p-5 rounded-2xl border-2 transition-all duration-300 flex flex-col justify-between focus:outline-none group overflow-hidden min-h-[9rem]
                                                                        {{ $isFull ? 'bg-red-50/50 dark:bg-red-950/10 border-red-200 dark:border-red-900/50 cursor-not-allowed opacity-75' : '' }}
                                                                        {{ !$isFull ? 'cursor-pointer hover:shadow-lg hover:-translate-y-0.5' : '' }}"
                                                                    :class="{
                                                                        'border-emerald-500 bg-emerald-50/30 dark:bg-emerald-950/20 ring-2 ring-emerald-500/20': selectedSession === '{{ $val }}' && !{{ $isFull ? 'true' : 'false' }},
                                                                        'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-emerald-300': selectedSession !== '{{ $val }}' && !{{ $isFull ? 'true' : 'false' }}
                                                                    }">
                                                                    
                                                                    {{-- Background Accent for Hover/Active --}}
                                                                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                                                    <div class="relative z-10 w-full flex items-center justify-between">
                                                                        {{-- Clock Icon or Checkmark --}}
                                                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300 shrink-0"
                                                                            :class="{
                                                                                'bg-emerald-500 text-white': selectedSession === '{{ $val }}' && !{{ $isFull ? 'true' : 'false' }},
                                                                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400': selectedSession !== '{{ $val }}' && !{{ $isFull ? 'true' : 'false' }},
                                                                                'bg-red-100 dark:bg-red-950/50 text-red-600': {{ $isFull ? 'true' : 'false' }}
                                                                            }">
                                                                            <template x-if="selectedSession === '{{ $val }}' && !{{ $isFull ? 'true' : 'false' }}">
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                                            </template>
                                                                            <template x-if="selectedSession !== '{{ $val }}' || {{ $isFull ? 'true' : 'false' }}">
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                            </template>
                                                                        </div>

                                                                        {{-- Badge --}}
                                                                        <div>
                                                                            @if($isFull)
                                                                                <span class="px-2.5 py-0.5 text-[10px] font-black tracking-wider uppercase rounded-full bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800">Penuh</span>
                                                                            @else
                                                                                <span class="px-2.5 py-0.5 text-[10px] font-black tracking-wider uppercase rounded-full bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">Tersedia</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    {{-- Session Info --}}
                                                                    <div class="relative z-10 w-full mt-4">
                                                                        <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide">Sesi {{ $loop->iteration }}</p>
                                                                        <h4 class="text-sm font-extrabold text-gray-800 dark:text-white mt-0.5">{{ $lbl }}</h4>
                                                                        
                                                                        {{-- Progress bar --}}
                                                                        <div class="w-full bg-gray-100 dark:bg-gray-700 h-1.5 rounded-full mt-2.5 overflow-hidden">
                                                                            @php
                                                                                $percentage = $max > 0 ? ($session['used'] / $max) * 100 : 0;
                                                                                $progressColor = $isFull ? 'bg-red-500' : ($percentage > 80 ? 'bg-amber-500' : 'bg-emerald-500');
                                                                            @endphp
                                                                            <div class="h-full {{ $progressColor }} transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                                                        </div>
                                                                        
                                                                        <div class="flex justify-between items-center mt-1.5 text-[10px] font-medium">
                                                                            <span class="{{ $isFull ? 'text-red-500' : 'text-gray-500 dark:text-gray-400' }}">
                                                                                {{ $isFull ? 'Kuota Habis' : "Sisa Kuota: $rem / $max" }}
                                                                            </span>
                                                                            <span class="text-gray-400 dark:text-gray-500">Terisi: {{ $session['used'] }}</span>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @elseif($field['type'] === 'select')
                                                    @php $fieldKey = $field['label']; $fieldId = 'field-input-' . $index; @endphp
                                                    
                                                    {{-- Hidden Input for Livewire Binding (Robust) --}}
                                                    <input type="hidden" id="{{ $fieldId }}" wire:model="data.{{ $fieldKey }}">

                                                    {{-- Visual Dropdown (Re-initialized on Livewire update) --}}
                                                    <div class="relative" x-data="{
                                                        open: false,
                                                        value: '', // Will init from hidden input
                                                        label: '',
                                                        options: {{ json_encode(collect($field['options'] ?? [])->map(fn($lbl, $val) => ['value' => (string)$val, 'label' => $lbl])->values()->toJson()) }},
                                                        init() {
                                                            this.sync();
                                                            // Observe changes to the hidden input
                                                            this.$watch('value', () => this.sync());
                                                        },
                                                        sync() {
                                                            let rawVal = document.getElementById('{{ $fieldId }}').value;
                                                            this.value = rawVal;
                                                            if(rawVal) {
                                                                let match = this.options.find(o => o.value == rawVal);
                                                                if(match) this.label = match.label;
                                                                else this.label = '';
                                                            } else {
                                                                this.label = '';
                                                            }
                                                        },
                                                        select(val, lbl) {
                                                            this.value = val;
                                                            this.label = lbl;
                                                            this.open = false;
                                                            
                                                            // Update Hidden Input & Trigger Event
                                                            let input = document.getElementById('{{ $fieldId }}');
                                                            input.value = val;
                                                            input.dispatchEvent(new Event('input'));
                                                        },
                                                        reset() {
                                                            this.value = '';
                                                            this.label = '';
                                                            this.open = false;

                                                            // Update Hidden Input & Trigger Event
                                                            let input = document.getElementById('{{ $fieldId }}');
                                                            input.value = '';
                                                            input.dispatchEvent(new Event('input'));
                                                        }
                                                    }" @click.away="open = false" @keydown.escape="open = false">
                                                        {{-- Trigger --}}
                                                        <button type="button" @click="open = !open"
                                                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl border text-sm transition duration-200 text-left"
                                                            :class="open 
                                                                ? 'border-emerald-500 ring-2 ring-emerald-500 bg-white dark:bg-gray-700' 
                                                                : 'border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 hover:border-emerald-300'">
                                                            <span :class="value ? 'text-gray-900 dark:text-white' : 'text-gray-400'" x-text="value ? label : 'Pilih {{ strtolower($field['label']) }}...'"></span>
                                                            <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180 text-emerald-500' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                            </svg>
                                                        </button>

                                                        {{-- Dropdown --}}
                                                        <div x-show="open" 
                                                            x-transition:enter="transition ease-out duration-200" 
                                                            x-transition:enter-start="opacity-0 -translate-y-2" 
                                                            x-transition:enter-end="opacity-100 translate-y-0" 
                                                            x-transition:leave="transition ease-in duration-100" 
                                                            x-transition:leave-start="opacity-100" 
                                                            x-transition:leave-end="opacity-0"
                                                            class="absolute z-50 mt-2 w-full bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden max-h-60 overflow-y-auto"
                                                            style="display: none;">

                                                            <button type="button" @click="reset()"
                                                                class="w-full flex items-center px-4 py-2.5 text-sm text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition border-b border-gray-100 dark:border-gray-700">
                                                                Pilih {{ strtolower($field['label']) }}...
                                                            </button>

                                                            @foreach($field['options'] ?? [] as $optVal => $optLabel)
                                                                <button type="button" @click="select('{{ $optVal }}', '{{ $optLabel }}')"
                                                                    class="w-full flex items-center justify-between px-4 py-2.5 text-sm transition"
                                                                    :class="value === '{{ $optVal }}'
                                                                        ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 font-semibold'
                                                                        : 'text-gray-700 dark:text-gray-300 hover:bg-emerald-50/60 dark:hover:bg-gray-700'">
                                                                    <span>{{ $optLabel }}</span>
                                                                    <svg x-show="value === '{{ $optVal }}'" class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                                    </svg>
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @elseif($field['type'] === 'select_with_input')
                                                    @php 
                                                        $fieldKey = $field['label']; 
                                                        $fieldId = 'field-input-' . $index; 
                                                        $optionsData = collect($field['options'] ?? [])->map(fn($lbl, $val) => ['value' => (string)$val, 'label' => $lbl])->values()->toArray();
                                                        $optionsData[] = ['value' => 'Lainnya', 'label' => 'Lainnya (Isi Sendiri)'];
                                                    @endphp
                                                    
                                                    {{-- Hidden Input for Livewire Binding --}}
                                                    <input type="hidden" id="{{ $fieldId }}" wire:model="data.{{ $fieldKey }}">

                                                    <div class="relative w-full" x-data="{
                                                        open: false,
                                                        value: '',
                                                        label: '',
                                                        customValue: '',
                                                        options: {{ json_encode($optionsData) }},
                                                        isOther() {
                                                            return this.value === 'Lainnya';
                                                        },
                                                        init() {
                                                            this.sync();
                                                        },
                                                        sync() {
                                                            let rawVal = document.getElementById('{{ $fieldId }}').value;
                                                            if(rawVal && !this.options.find(o => o.value == rawVal) && rawVal !== 'Lainnya') {
                                                                this.customValue = rawVal;
                                                                this.value = 'Lainnya';
                                                                this.label = 'Lainnya (Isi Sendiri)';
                                                            } else {
                                                                this.value = rawVal;
                                                                if(rawVal) {
                                                                    let match = this.options.find(o => o.value == rawVal);
                                                                    if(match) this.label = match.label;
                                                                    else this.label = '';
                                                                } else {
                                                                    this.label = '';
                                                                }
                                                            }
                                                        },
                                                        select(val, lbl) {
                                                            this.value = val;
                                                            this.label = lbl;
                                                            this.open = false;
                                                            
                                                            let input = document.getElementById('{{ $fieldId }}');
                                                            if (val !== 'Lainnya') {
                                                                input.value = val;
                                                                this.customValue = '';
                                                            } else {
                                                                input.value = this.customValue;
                                                            }
                                                            input.dispatchEvent(new Event('input'));
                                                        },
                                                        updateCustom() {
                                                            if (this.value === 'Lainnya') {
                                                                let input = document.getElementById('{{ $fieldId }}');
                                                                input.value = this.customValue;
                                                                input.dispatchEvent(new Event('input'));
                                                            }
                                                        },
                                                        reset() {
                                                            this.value = '';
                                                            this.label = '';
                                                            this.customValue = '';
                                                            this.open = false;
                                                            let input = document.getElementById('{{ $fieldId }}');
                                                            input.value = '';
                                                            input.dispatchEvent(new Event('input'));
                                                        }
                                                    }" @click.away="open = false" @keydown.escape="open = false">
                                                        
                                                        {{-- Trigger --}}
                                                        <button type="button" @click="open = !open"
                                                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl border text-sm transition duration-200 text-left"
                                                            :class="[
                                                                open ? 'border-emerald-500 ring-2 ring-emerald-500 bg-white dark:bg-gray-700' : 'border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 hover:border-emerald-300',
                                                                isOther() ? 'mb-3' : ''
                                                            ]">
                                                            <span :class="value ? 'text-gray-900 dark:text-white' : 'text-gray-400'" x-text="value ? label : 'Pilih {{ strtolower($field['label']) }}...'"></span>
                                                            <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180 text-emerald-500' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                            </svg>
                                                        </button>

                                                        {{-- Dropdown list --}}
                                                        <div x-show="open" 
                                                            x-transition:enter="transition ease-out duration-200" 
                                                            x-transition:enter-start="opacity-0 -translate-y-2" 
                                                            x-transition:enter-end="opacity-100 translate-y-0" 
                                                            x-transition:leave="transition ease-in duration-100" 
                                                            x-transition:leave-start="opacity-100" 
                                                            x-transition:leave-end="opacity-0"
                                                            class="absolute z-50 mt-2 w-full bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden max-h-60 overflow-y-auto"
                                                            style="display: none;">

                                                            <button type="button" @click="reset()"
                                                                class="w-full flex items-center px-4 py-2.5 text-sm text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition border-b border-gray-100 dark:border-gray-700">
                                                                Pilih {{ strtolower($field['label']) }}...
                                                            </button>

                                                            <template x-for="opt in options" :key="opt.value">
                                                                <button type="button" @click="select(opt.value, opt.label)"
                                                                    class="w-full flex items-center justify-between px-4 py-2.5 text-sm transition"
                                                                    :class="value === opt.value
                                                                        ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 font-semibold'
                                                                        : 'text-gray-700 dark:text-gray-300 hover:bg-emerald-50/60 dark:hover:bg-gray-700'">
                                                                    <span x-text="opt.label" class="text-left"></span>
                                                                    <svg x-show="value === opt.value" class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                                    </svg>
                                                                </button>
                                                            </template>
                                                        </div>

                                                        {{-- Custom Input --}}
                                                        <div x-show="isOther()" x-transition x-cloak>
                                                            <input
                                                                type="text"
                                                                x-model="customValue"
                                                                @input="updateCustom()"
                                                                placeholder="Ketik {{ strtolower($field['label']) }} di sini..."
                                                                class="w-full px-4 py-3 rounded-xl border border-emerald-300 dark:border-emerald-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 text-sm shadow-sm"
                                                            >
                                                        </div>
                                                    </div>
                                                @elseif($field['type'] === 'date')
                                                    @php $dateFieldKey = $field['label']; $fieldId = 'field-input-' . $index; @endphp
                                                    
                                                    {{-- Hidden Input for Livewire Binding --}}
                                                    <input type="hidden" id="{{ $fieldId }}" wire:model="data.{{ $dateFieldKey }}">

                                                    <div class="relative" x-data="{
                                                        fp: null,
                                                        displayValue: '',
                                                        months: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
                                                        formatDate(dateStr) {
                                                            if (!dateStr) return '';
                                                            const d = new Date(dateStr + 'T00:00:00');
                                                            return d.getDate() + ' ' + this.months[d.getMonth()] + ' ' + d.getFullYear();
                                                        },
                                                        sync() {
                                                            let rawVal = document.getElementById('{{ $fieldId }}').value;
                                                            if(rawVal && this.fp) {
                                                                this.fp.setDate(rawVal);
                                                                this.displayValue = this.formatDate(rawVal);
                                                            } else if (rawVal) {
                                                                this.displayValue = this.formatDate(rawVal);
                                                            } else {
                                                                this.displayValue = '';
                                                                if (this.fp) this.fp.clear();
                                                            }
                                                        },
                                                        init() {
                                                            const el = this.$refs.dateinput;
                                                            const component = this;
                                                            let rawVal = document.getElementById('{{ $fieldId }}').value;
                                                            
                                                            if (typeof flatpickr !== 'undefined') {
                                                                this.fp = flatpickr(el, {
                                                                    dateFormat: 'Y-m-d',
                                                                    disableMobile: true,
                                                                    defaultDate: rawVal, // Set default date
                                                                    locale: {
                                                                        firstDayOfWeek: 1,
                                                                        weekdays: {
                                                                            shorthand: ['Min','Sen','Sel','Rab','Kam','Jum','Sab'],
                                                                            longhand: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']
                                                                        },
                                                                        months: {
                                                                            shorthand: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                                                                            longhand: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']
                                                                        }
                                                                    },
                                                                    onChange: function(selectedDates, dateStr) {
                                                                        component.displayValue = component.formatDate(dateStr);
                                                                        
                                                                        // Update Hidden Input & Trigger Event
                                                                        let input = document.getElementById('{{ $fieldId }}');
                                                                        input.value = dateStr;
                                                                        input.dispatchEvent(new Event('input'));
                                                                        @this.set('data.{{ $dateFieldKey }}', dateStr);
                                                                    }
                                                                });
                                                            }
                                                            this.sync();
                                                        }
                                                    }">
                                                        <input x-ref="dateinput" type="text" style="position:absolute;opacity:0;height:0;width:0;pointer-events:none;">
                                                        <button type="button" @click="fp && fp.open()"
                                                            class="w-full flex items-center px-4 py-3 pl-11 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-left text-sm transition duration-200 cursor-pointer hover:border-emerald-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                                            <span :class="displayValue ? 'text-gray-900 dark:text-white' : 'text-gray-400'" x-text="displayValue || 'Pilih tanggal...'"></span>
                                                        </button>
                                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                        </div>
                                                    </div>
                                                @elseif($field['type'] === 'file')
                                                    <div class="relative">
                                                        <input
                                                            type="file"
                                                            wire:model="data.{{ $field['label'] }}"
                                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                                        >
                                                        <div wire:loading wire:target="data.{{ $field['label'] }}" class="text-sm text-emerald-600 mt-1">Mengupload...</div>
                                                        
                                                        {{-- Indicator for pre-existing file in revision mode --}}
                                                        @if($revisionMode && isset($existingFilePaths[$field['label']]))
                                                            <div class="mt-2 p-3 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center justify-between text-sm">
                                                                <div class="flex items-center gap-2">
                                                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                    <span class="text-emerald-700 font-medium">File sudah terunggah sebelumnya.</span>
                                                                </div>
                                                                <a href="{{ Storage::url($existingFilePaths[$field['label']]) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800 underline font-semibold tooltip" title="Lihat File Lama">Lihat File Lama</a>
                                                            </div>
                                                            <p class="text-xs text-gray-500 mt-1">* Biarkan kosong jika tidak ingin mengubah file ini.</p>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="relative">
                                                        <input
                                                            type="{{ $field['type'] }}"
                                                            wire:model="data.{{ $field['label'] }}"
                                                            placeholder="Masukkan {{ strtolower($field['label']) }}..."
                                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 text-sm"
                                                        >
                                                        @if($field['type'] === 'email')
                                                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                            </div>
                                                        @elseif($field['type'] === 'number')
                                                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif

                                                @if(!empty($field['helper_text']))
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 ml-1 leading-relaxed">{!! nl2br(e($field['helper_text'])) !!}</p>
                                                @endif

                                                @error('data.' . $field['label'])
                                                    <div class="flex items-center mt-2 text-red-500 text-sm">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Submit Button --}}
                                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                                        <button
                                            type="submit"
                                            class="w-full inline-flex items-center justify-center px-8 py-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-bold text-sm tracking-wide shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:from-emerald-700 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 transform hover:-translate-y-0.5"
                                            wire:loading.attr="disabled"
                                            wire:loading.class="opacity-70 cursor-not-allowed"
                                        >
                                            <span wire:loading.remove>
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                            </span>
                                            <span wire:loading>
                                                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            </span>
                                            <span wire:loading.remove>Kirim Formulir</span>
                                            <span wire:loading>Mengirim...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        @endif

                        {{-- SUBMISSIONS HISTORY --}}
                        @if(!$isDashboard && !$showForm && count($mySubmissions) > 0)
                            @php
                                // Workflow steps for ISBN tracker
                                $isbnTrackerSteps = [
                                    ['key' => 'data_diterima',        'label' => 'Data Diterima',        'icon' => '📥'],
                                    ['key' => 'verifikasi_kemenag',   'label' => 'Verifikasi Kemenag',   'icon' => '🔍'],
                                    ['key' => 'proses_pengajuan',     'label' => 'Proses Pengajuan',     'icon' => '📤'],
                                    ['key' => 'verifikasi_perpusnas', 'label' => 'Verifikasi Perpusnas', 'icon' => '📚'],
                                    ['key' => 'isbn_terbit',          'label' => 'ISBN Terbit',          'icon' => '✅'],
                                    ['key' => 'penyerahan_buku',      'label' => 'Penyerahan Buku',      'icon' => '📖'],
                                    ['key' => 'selesai',              'label' => 'Selesai',              'icon' => '🎉'],
                                ];
                                $wfStepKeys = collect($isbnTrackerSteps)->pluck('key')->toArray();
                                // Detect if this is the ISBN form
                                $isIsbnForm = ($form->slug ?? '') === 'pengajuan-isbn';
                            @endphp

                            <div class="space-y-4">
                                @foreach($mySubmissions as $index => $submission)
                                    @php
                                        $wfStatus    = $submission['workflow_status'] ?? 'data_diterima';
                                        $isRevision  = $wfStatus === 'perlu_diperbaiki';
                                        $isbnNo      = $submission['isbn_number'] ?? null;
                                        $revNotes    = $submission['revision_notes'] ?? null;
                                        $trackerIdx  = array_search($wfStatus, $wfStepKeys);
                                        if ($isRevision) $trackerIdx = array_search('verifikasi_kemenag', $wfStepKeys);
                                        $legacyStatus = $submission['status'] ?? 'pending';
                                        $badges = [
                                            'pending'  => ['bg-yellow-100 text-yellow-800 border-yellow-200', 'Menunggu'],
                                            'approved' => ['bg-emerald-100 text-emerald-800 border-emerald-200', 'Disetujui'],
                                            'rejected' => ['bg-red-100 text-red-800 border-red-200', 'Ditolak'],
                                        ];
                                        $badge = $badges[$legacyStatus] ?? $badges['pending'];
                                    @endphp

                                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border {{ $isRevision ? 'border-red-300 dark:border-red-700' : 'border-gray-100 dark:border-gray-700' }} overflow-hidden"
                                         x-data="{ expanded: {{ $index === 0 ? 'true' : 'false' }} }">

                                        {{-- Revision Alert Banner (for ISBN form only) --}}
                                        @if($isIsbnForm && $isRevision)
                                            <div class="bg-red-500 px-6 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                                <div class="flex items-center gap-2 text-white">
                                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                    <div>
                                                        <p class="font-semibold text-sm">Pengajuan ini perlu diperbaiki!</p>
                                                        @if($revNotes)
                                                            <p class="text-xs text-red-100">Catatan admin: {{ $revNotes }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <button wire:click="loadForRevision({{ $submission['id'] }})" @click.stop
                                                    class="shrink-0 bg-white text-red-600 hover:bg-red-50 font-semibold text-xs px-4 py-2 rounded-lg transition-colors">
                                                    Ajukan Perbaikan →
                                                </button>
                                            </div>
                                        @endif

                                        {{-- Submission Header --}}
                                        <button @click="expanded = !expanded" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition group">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                                                    <span class="text-sm font-bold text-emerald-700 dark:text-emerald-400">#{{ count($mySubmissions) - $index }}</span>
                                                </div>
                                                <div class="text-left">
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Pengiriman #{{ count($mySubmissions) - $index }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($submission['created_at'])->translatedFormat('d M Y, H:i') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-3">
                                                {{-- Workflow badge (ISBN) OR legacy badge (other forms) --}}
                                                @if($isIsbnForm)
                                                    @php
                                                        $wfBadgeColors = [
                                                            'data_diterima'        => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                            'verifikasi_kemenag'   => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                            'perlu_diperbaiki'     => 'bg-red-100 text-red-800 border-red-200',
                                                            'menunggu_review'      => 'bg-cyan-100 text-cyan-800 border-cyan-200',
                                                            'proses_pengajuan'     => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                            'verifikasi_perpusnas' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                            'isbn_terbit'          => 'bg-green-100 text-green-800 border-green-200',
                                                            'penyerahan_buku'      => 'bg-teal-100 text-teal-800 border-teal-200',
                                                            'selesai'              => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                        ];
                                                        $wfLabels = [
                                                            'data_diterima'        => 'Data Diterima',
                                                            'verifikasi_kemenag'   => 'Verifikasi Kemenag',
                                                            'perlu_diperbaiki'     => 'Perlu Perbaikan',
                                                            'menunggu_review'      => 'Sudah Diperbaiki',
                                                            'proses_pengajuan'     => 'Diproses',
                                                            'verifikasi_perpusnas' => 'Verifikasi Perpusnas',
                                                            'isbn_terbit'          => 'ISBN Terbit',
                                                            'penyerahan_buku'      => 'Penyerahan Buku',
                                                            'selesai'              => 'Selesai',
                                                        ];
                                                    @endphp
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $wfBadgeColors[$wfStatus] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                                        {{ $wfLabels[$wfStatus] ?? ucfirst($wfStatus) }}
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badge[0] }}">
                                                        {{ $badge[1] }}
                                                    </span>
                                                @endif

                                                {{-- Download Ticket --}}
                                                @if($legacyStatus === 'approved' && !empty($submission['ticket_path']))
                                                    <!-- Fonts loaded globally via Vite -->
                                                    <!-- Flaticon Uicons loaded globally -->
                                                    <a href="{{ Storage::url($submission['ticket_path']) }}" target="_blank" download @click.stop class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition border border-transparent hover:border-emerald-200" title="Download Tiket">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                    </a>
                                                @endif

                                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-transform duration-200" :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </div>
                                        </button>

                                        {{-- Expandable Content --}}
                                        <div x-show="expanded" x-transition class="border-t border-gray-100 dark:border-gray-700">

                                            {{-- ===== ISBN PROGRESS TRACKER (VERTICAL) ===== --}}
                                            @if($isIsbnForm)
                                                @php
                                                    // Inline SVG paths (Heroicons) per step
                                                    $stepSvgs = [
                                                        'data_diterima'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>',
                                                        'verifikasi_kemenag'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                                                        'proses_pengajuan'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>',
                                                        'verifikasi_perpusnas' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                                                        'isbn_terbit'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
                                                        'penyerahan_buku'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1.628 8.14A2 2 0 008.616 18h6.768a2 2 0 001.988-1.86L19 8M10 12h4"/>',
                                                        'selesai'              => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
                                                    ];
                                                @endphp
                                                <div class="px-6 pt-5 pb-6 bg-gray-50 dark:bg-gray-800/50">
                                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Progres Pengajuan</p>

                                                    {{-- Vertical Stepper --}}
                                                    <div class="relative">
                                                        @foreach($isbnTrackerSteps as $sIdx => $step)
                                                            @php
                                                                $isDone    = $sIdx < $trackerIdx;
                                                                $isCurrent = $sIdx === $trackerIdx;
                                                                $isPending = $sIdx > $trackerIdx;
                                                                $isLast    = $sIdx === count($isbnTrackerSteps) - 1;
                                                                $svgPath   = $stepSvgs[$step['key']] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>';
                                                            @endphp
                                                            <div class="flex items-start gap-4 {{ !$isLast ? 'pb-5' : '' }}">
                                                                {{-- Icon Column --}}
                                                                <div class="flex flex-col items-center shrink-0">
                                                                    {{-- Circle --}}
                                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all
                                                                        {{ $isDone    ? 'bg-emerald-500 border-emerald-500 text-white shadow' : '' }}
                                                                        {{ $isCurrent && !$isRevision ? 'bg-white dark:bg-gray-800 border-blue-600 text-blue-600 shadow-lg ring-4 ring-blue-100 dark:ring-blue-900/50' : '' }}
                                                                        {{ $isCurrent && $isRevision  ? 'bg-red-500 border-red-500 text-white shadow-lg ring-4 ring-red-200 dark:ring-red-900/50' : '' }}
                                                                        {{ $isPending ? 'bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-400' : '' }}">
                                                                        @if($isDone)
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                                            </svg>
                                                                        @else
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                {!! $svgPath !!}
                                                                            </svg>
                                                                        @endif
                                                                    </div>
                                                                    {{-- Connector line --}}
                                                                    @if(!$isLast)
                                                                        <div class="w-0.5 flex-1 mt-1
                                                                            {{ $isDone ? 'bg-emerald-400' : 'bg-gray-200 dark:bg-gray-600' }}
                                                                            " style="min-height: 24px;"></div>
                                                                    @endif
                                                                </div>

                                                                {{-- Label Column --}}
                                                                <div class="pt-1.5 flex-1 min-w-0">
                                                                    <p class="text-sm font-semibold leading-none
                                                                        {{ $isDone    ? 'text-emerald-700 dark:text-emerald-400' : '' }}
                                                                        {{ $isCurrent && !$isRevision ? 'text-amber-700 dark:text-amber-400' : '' }}
                                                                        {{ $isCurrent && $isRevision  ? 'text-red-700 dark:text-red-400' : '' }}
                                                                        {{ $isPending ? 'text-gray-400 dark:text-gray-500' : '' }}">
                                                                        {{ $step['label'] }}
                                                                        @if($isCurrent && !$isRevision)
                                                                            <span class="ml-2 text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300 px-1.5 py-0.5 rounded-full uppercase tracking-wide">Sekarang</span>
                                                                        @elseif($isCurrent && $isRevision)
                                                                            <span class="ml-2 text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 px-1.5 py-0.5 rounded-full uppercase tracking-wide">Perlu Perbaikan</span>
                                                                        @elseif($isDone)
                                                                            <span class="ml-2 text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 px-1.5 py-0.5 rounded-full uppercase tracking-wide">Selesai</span>
                                                                        @endif
                                                                    </p>
                                                                    {{-- Show ISBN if terbit --}}
                                                                    @if($step['key'] === 'isbn_terbit' && $isbnNo)
                                                                        <div class="mt-1 flex flex-wrap gap-2">
                                                                            <span class="text-xs font-mono text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/20 inline-block px-2 py-0.5 rounded">ISBN: {{ $isbnNo }}</span>
                                                                            @if($wfStatus === 'penyerahan_buku')
                                                                                <span class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/30 inline-block px-2 py-0.5 rounded">KCKR Belum Diserahkan</span>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        {{-- Revision notice --}}
                                                        @if($isRevision)
                                                            <div class="mt-2 p-3 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-200 dark:border-red-800">
                                                                <p class="text-xs text-red-700 dark:text-red-300">
                                                                    <i class="fi fi-rr-exclamation mr-1"></i>
                                                                    Dikembalikan untuk diperbaiki. Klik <strong>Ajukan Perbaikan</strong> di atas.
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Submission Data (hidden for ISBN form, only tracker shown) --}}
                                            @if(!$isIsbnForm)
                                            <div class="px-6 py-4 space-y-3">
                                                @if(is_array($submission['data']))
                                                    @foreach($submission['data'] as $key => $value)
                                                        <div class="flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-4">
                                                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider sm:w-1/3 flex-shrink-0">{{ $key }}</span>
                                                            <div class="sm:w-2/3">
                                                                @if(is_string($value) && Str::startsWith($value, 'form_submissions/'))
                                                                    <a href="{{ Storage::url($value) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800 text-sm flex items-center gap-1">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                                        Lihat File
                                                                    </a>
                                                                @else
                                                                    <span class="text-sm text-gray-900 dark:text-white">{{ is_array($value) ? implode(', ', $value) : ($value ?: '-') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            @endif {{-- !$isIsbnForm --}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </section>
    @else
        {{-- Not Found State --}}
        <section class="py-24 text-center">
            <div class="max-w-md mx-auto px-4">
                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Formulir Tidak Ditemukan</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Formulir yang Anda cari tidak ditemukan atau sudah tidak aktif.</p>
                <a href="{{ route('landing') }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </section>
    @endif
</div>
