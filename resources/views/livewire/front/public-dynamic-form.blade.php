@if($form)
    <!-- Dynamic Theme Customizer Styles -->
    <style>
        :root {
            --theme-primary: {{ $form->theme_color ?? '#059669' }};
            --theme-bg: {{ $form->bg_color ?? '#f0fdf4' }};
        }
        
        body {
            background-color: var(--theme-bg) !important;
            transition: background-color 0.3s ease;
        }

        /* Focus rings and inputs overrides - Google Form style underline */
        input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]),
        textarea,
        select {
            border: none !important;
            border-bottom: 2px solid #e5e7eb !important;
            border-radius: 0 !important;
            padding-left: 0 !important;
            box-shadow: none !important;
            background: transparent !important;
            transition: border-color 0.2s ease !important;
        }
        
        input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):hover,
        textarea:hover,
        select:hover {
            border-bottom-color: #9ca3af !important;
        }
        
        input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):focus,
        textarea:focus,
        select:focus {
            border-bottom-color: var(--theme-primary) !important;
            box-shadow: none !important;
            outline: none !important;
            --tw-ring-color: transparent !important;
        }
        
        /* Captcha input - keep bordered box style */
        input[type="number"] {
            border: 2px solid #e5e7eb !important;
            border-radius: 12px !important;
            padding-left: 12px !important;
            background: white !important;
        }
        input[type="number"]:hover {
            border-color: #9ca3af !important;
        }
        input[type="number"]:focus {
            border-color: var(--theme-primary) !important;
            border-bottom-color: var(--theme-primary) !important;
        }
        
        /* Custom select styling */
        .border-emerald-500, .border-emerald-300 {
            border-color: var(--theme-primary) !important;
        }
        
        .focus\:ring-emerald-500:focus, .focus\:border-emerald-500:focus {
            --tw-ring-color: var(--theme-primary) !important;
            border-color: var(--theme-primary) !important;
        }
        
        /* Peer classes overrides for Custom Select, Radio, Checkbox */
        .peer:checked ~ div {
            border-color: var(--theme-primary) !important;
            background-color: var(--theme-primary) !important;
        }
        
        .peer-checked\:border-emerald-500:checked + div, 
        .peer-checked\:bg-emerald-500:checked + div,
        .peer:checked ~ .peer-checked\:border-emerald-500 {
            border-color: var(--theme-primary) !important;
        }
        
        /* Custom radio inner dot */
        .bg-emerald-500 {
            background-color: var(--theme-primary) !important;
        }
        
        /* Text accents */
        .text-emerald-600, .text-emerald-500, .text-emerald-300, .text-emerald-700, .group-focus-within\:text-emerald-600 {
            color: var(--theme-primary) !important;
        }
        
        /* Checkbox check icon show */
        .peer:checked ~ div svg {
            opacity: 1 !important;
        }
        
        /* Helper circles & backgrounds */
        .bg-emerald-100 {
            background-color: {{ ($form->theme_color ?? '#059669') . '1a' }} !important; /* 10% opacity */
            color: var(--theme-primary) !important;
        }
        
        .bg-emerald-50 {
            background-color: {{ ($form->theme_color ?? '#059669') . '0d' }} !important; /* 5% opacity */
        }
        
        /* Submit button customization */
        .from-emerald-600 {
            --tw-gradient-from: var(--theme-primary) !important;
            --tw-gradient-to: {{ ($form->theme_color ?? '#059669') . 'cc' }} !important;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to) !important;
        }
        
        .shadow-emerald-500\/20 {
            --tw-shadow-color: {{ ($form->theme_color ?? '#059669') . '33' }} !important;
            --tw-shadow: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color) !important;
        }
    </style>
@endif

<div class="relative min-h-[80vh] py-12 px-4 sm:px-6 lg:px-8 flex flex-col justify-center" x-data="{ submitting: false }">

    <div class="relative z-10 max-w-3xl mx-auto w-full">
        @if(!$form)
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="mx-auto w-20 h-20 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                    <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Formulir Tidak Ditemukan</h3>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Maaf, formulir yang Anda cari tidak tersedia atau sudah ditutup.</p>
                <a href="{{ url('/') }}" class="mt-6 inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 transition">
                    Kembali ke Beranda
                </a>
            </div>
        @else
            <!-- Minimalist Header Section -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden relative text-gray-900 dark:text-white">
                
                @if($form->cover_image) 
                    <!-- Banner image on top (like Google Forms) -->
                    <div class="w-full h-48 sm:h-56 md:h-64 overflow-hidden border-b border-gray-100 dark:border-gray-700">
                        <img src="{{ Storage::url($form->cover_image) }}" alt="Banner" class="w-full h-full object-cover">
                    </div>
                @else
                    <!-- Top Accent Line (only when no cover image) -->
                    <div class="absolute top-0 inset-x-0 h-1.5" style="background-color: var(--theme-primary);"></div>
                @endif

                <div class="p-8 md:p-10 relative z-10 flex flex-col items-center">
                    <!-- Brand Logo Kemenag RI -->
                    <div class="mb-5 flex flex-col items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Kemenag" class="w-12 h-12 object-contain mb-2">
                        <span class="text-[9px] sm:text-[10px] font-bold tracking-[0.2em] text-gray-400 dark:text-gray-500 uppercase">Kementerian Agama Republik Indonesia</span>
                        <span class="text-[11px] sm:text-[12px] font-medium text-gray-500 dark:text-gray-400">Perpustakaan Kemenag RI</span>
                    </div>
                    
                    {{-- Elegant Divider line --}}
                    <div class="w-16 h-[1.5px] bg-gray-100 dark:bg-gray-700 mb-5"></div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-3 text-center text-gray-900 dark:text-white">
                        @if(str_starts_with($slug ?? '', 'daftar-hadir-') && !str_contains(strtolower($form->title), 'daftar hadir'))
                            Daftar Hadir {{ $form->title }}
                        @else
                            {{ $form->title }}
                        @endif
                    </h1>
                    
                    @if($form->description)
                        @if(strip_tags($form->description) !== $form->description)
                            <div class="text-sm sm:text-base text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-6 leading-relaxed text-left">{!! $form->description !!}</div>
                        @else
                            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-6 text-center leading-relaxed whitespace-pre-line">{!! nl2br(e($form->description)) !!}</p>
                        @endif
                    @endif

                    <div class="flex flex-wrap justify-center gap-2.5 text-xs">
                        @if($form->start_date || $form->end_date)
                            <div class="flex items-center bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 px-3.5 py-1.5 rounded-lg border border-gray-100 dark:border-gray-700">
                                <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
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
                            <div class="flex items-center bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 px-3.5 py-1.5 rounded-lg border border-gray-100 dark:border-gray-700">
                                <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span>Sisa Kuota: <strong>{{ $remainingQuota }} / {{ $form->max_quota }}</strong> Peserta</span>
                            </div>
                        @else
                            <div class="flex items-center bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 px-3.5 py-1.5 rounded-lg border border-gray-100 dark:border-gray-700">
                                <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Akses Terbuka & Bebas Kuota</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if(!$showForm)
                <!-- Success State -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-all duration-500 hover:scale-[1.01]">
                    <div class="h-1.5 w-full" style="background-color: var(--theme-primary);"></div>
                    <div class="p-10 md:p-16 text-center">
                        <div class="w-20 h-20 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                            <svg class="w-10 h-10 text-emerald-600 dark:text-emerald-400 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3 tracking-tight">Kehadiran Tercatat!</h2>
                        <p class="text-base text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">{{ $successMessage }}</p>
                        
                        <div class="flex flex-col sm:flex-row justify-center gap-3.5 max-w-md mx-auto">
                            <button wire:click="toggleForm" class="flex-1 inline-flex justify-center items-center px-5 py-3 border border-transparent text-sm font-bold rounded-xl text-white transition-all duration-300" style="background-color: var(--theme-primary);">
                                Isi Kembali
                            </button>
                            <a href="{{ url('/') }}" class="flex-1 inline-flex justify-center items-center px-5 py-3 border border-gray-200 dark:border-gray-700 text-sm font-bold rounded-xl text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-850 hover:bg-gray-50 focus:outline-none transition-all duration-300">
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Main Form - Google Form Style (each field = separate card) -->
                <div class="relative">
                    <div class="space-y-4">
                        <form wire:submit.prevent="submit" class="space-y-4" x-on:submit="submitting = true">
                            
                            {{-- Hidden: auto-fill Kegiatan for daftar-hadir forms --}}
                            @if(str_starts_with($slug ?? '', 'daftar-hadir-'))
                                <input type="hidden" wire:model="data.Kegiatan" value="{{ $form->title }}">
                            @endif

                            @foreach($form->fields as $index => $field)
                                @php
                                    // Skip "Kegiatan" field for daftar-hadir forms — auto-filled as hidden
                                    if (str_starts_with($slug ?? '', 'daftar-hadir-') && strtolower($field['label']) === 'kegiatan') {
                                        continue;
                                    }

                                    $optionsArr = [];
                                    if (isset($field['options'])) {
                                        if (is_array($field['options'])) {
                                            $optionsArr = $field['options'];
                                        } else if (is_string($field['options']) && !empty($field['options'])) {
                                            $optionsArr = array_map('trim', explode(',', $field['options']));
                                            $optionsArr = array_combine($optionsArr, $optionsArr);
                                        }
                                    }
                                @endphp

                                {{-- Google Form style: each field is its own card --}}
                                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 transition-all duration-200 focus-within:border-l-4 focus-within:border-l-emerald-500 focus-within:shadow-md hover:shadow-md hover:border-gray-300 group">
                                    <label for="field_{{ $index }}" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">
                                        {{ $field['label'] }}
                                        @if($field['required'])
                                            <span class="text-red-500 ml-0.5">*</span>
                                        @endif
                                    </label>
                                    <div class="mt-1">
                                        @if($field['type'] === 'textarea')
                                                <textarea 
                                                    id="field_{{ $index }}" 
                                                    wire:model="data.{{ $field['label'] }}"
                                                    rows="4"
                                                    class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 bg-transparent dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-base transition-all duration-300 hover:border-emerald-300 px-5 py-4 resize-none"
                                                    placeholder="Ketikkan jawaban Anda..."
                                                    {{ $field['required'] ? 'required' : '' }}
                                                ></textarea>
                                            
                                            @elseif($field['type'] === 'select')
                                                <div class="relative" x-data="{ 
                                                    open: false, 
                                                    selected: @entangle('data.' . $field['label']),
                                                    options: {
                                                        @foreach($optionsArr as $optVal => $optLabel)
                                                            '{{ $optVal }}': '{{ $optLabel }}',
                                                        @endforeach
                                                    },
                                                    get selectedLabel() {
                                                        return this.selected ? (this.options[this.selected] || this.selected) : '';
                                                    },
                                                    select(val) {
                                                        this.selected = val;
                                                        this.open = false;
                                                    }
                                                }" @click.away="open = false" @keydown.escape.window="open = false">
                                                    {{-- Hidden input for form validation --}}
                                                    <input type="hidden" wire:model="data.{{ $field['label'] }}" {{ $field['required'] ? 'required' : '' }}>

                                                    {{-- Trigger Button --}}
                                                    <button type="button" @click="open = !open"
                                                        class="relative w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900/80 pl-5 pr-12 py-4 text-left cursor-pointer transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 hover:border-emerald-300 hover:shadow-md"
                                                        :class="open ? 'ring-2 ring-emerald-500 border-emerald-500 shadow-lg shadow-emerald-500/10' : ''">
                                                        <span class="block truncate text-base" :class="selected ? 'text-gray-900 dark:text-white font-medium' : 'text-gray-400 dark:text-gray-500'">
                                                            <template x-if="selected"><span x-text="selectedLabel"></span></template>
                                                            <template x-if="!selected"><span>-- Silakan Pilih --</span></template>
                                                        </span>
                                                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                                            <svg class="h-5 w-5 text-emerald-500 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                        </span>
                                                    </button>

                                                    {{-- Dropdown Panel --}}
                                                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                                                        class="absolute z-50 mt-2 w-full rounded-2xl bg-white dark:bg-gray-800 shadow-2xl shadow-gray-900/20 dark:shadow-black/40 ring-1 ring-gray-900/5 dark:ring-white/10 overflow-hidden max-h-60 overflow-y-auto"
                                                        style="display: none;">
                                                        @foreach($optionsArr as $optVal => $optLabel)
                                                            <div @click="select('{{ $optVal }}')"
                                                                class="relative cursor-pointer select-none px-5 py-3.5 transition-all duration-150 flex items-center justify-between group"
                                                                :class="selected === '{{ $optVal }}' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                                                                <span class="block truncate text-sm font-medium" :class="selected === '{{ $optVal }}' ? 'font-bold' : ''">{{ $optLabel }}</span>
                                                                <svg x-show="selected === '{{ $optVal }}'" class="w-5 h-5 text-emerald-500 flex-shrink-0 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                
                                            @elseif($field['type'] === 'radio')
                                                <div class="mt-3 space-y-4 sm:space-y-0 sm:flex sm:gap-6 px-2">
                                                    @foreach($optionsArr as $optVal => $optLabel)
                                                        <label class="relative flex items-center cursor-pointer group/radio">
                                                            <div class="relative flex items-center justify-center">
                                                                <input 
                                                                    type="radio" 
                                                                    wire:model="data.{{ $field['label'] }}"
                                                                    value="{{ $optVal }}"
                                                                    class="peer sr-only"
                                                                    {{ $field['required'] ? 'required' : '' }}
                                                                >
                                                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-focus:ring-2 peer-focus:ring-emerald-500 transition-all"></div>
                                                                <div class="absolute w-3 h-3 rounded-full bg-emerald-500 scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                                            </div>
                                                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover/radio:text-emerald-600 transition-colors">{{ $optLabel }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                
                                            @elseif($field['type'] === 'checkbox')
                                                <div class="mt-3 space-y-4 px-2">
                                                    @if(empty($optionsArr) || count($optionsArr) == 1)
                                                        {{-- Single Checkbox (Boolean) --}}
                                                        <label class="relative flex items-start cursor-pointer group/check">
                                                            <div class="flex items-center h-6">
                                                                <input 
                                                                    type="checkbox" 
                                                                    wire:model="data.{{ $field['label'] }}"
                                                                    class="peer sr-only"
                                                                    {{ $field['required'] ? 'required' : '' }}
                                                                >
                                                                <div class="w-6 h-6 rounded-lg border-2 border-gray-300 peer-checked:bg-emerald-500 peer-checked:border-emerald-500 peer-focus:ring-2 peer-focus:ring-emerald-500 transition-all flex items-center justify-center">
                                                                    <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                                </div>
                                                            </div>
                                                            <div class="ml-3 text-sm font-medium mt-0.5">
                                                                <span class="text-gray-700 dark:text-gray-300 group-hover/check:text-emerald-600 transition-colors">{{ empty($optionsArr) ? 'Ya, Saya Setuju' : reset($optionsArr) }}</span>
                                                            </div>
                                                        </label>
                                                    @else
                                                        {{-- Multiple Checkbox Group --}}
                                                        @foreach($optionsArr as $optVal => $optLabel)
                                                            <label class="relative flex items-start cursor-pointer group/check">
                                                                <div class="flex items-center h-6">
                                                                    <input 
                                                                        type="checkbox" 
                                                                        wire:model="data.{{ $field['label'] }}][]"
                                                                        value="{{ $optVal }}"
                                                                        class="peer sr-only"
                                                                    >
                                                                    <div class="w-6 h-6 rounded-lg border-2 border-gray-300 peer-checked:bg-emerald-500 peer-checked:border-emerald-500 peer-focus:ring-2 peer-focus:ring-emerald-500 transition-all flex items-center justify-center">
                                                                        <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                                    </div>
                                                                </div>
                                                                <div class="ml-3 text-sm font-medium mt-0.5">
                                                                    <span class="text-gray-700 dark:text-gray-300 group-hover/check:text-emerald-600 transition-colors">{{ $optLabel }}</span>
                                                                </div>
                                                            </label>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                
                                            @else
                                                <input 
                                                    type="{{ $field['type'] }}" 
                                                    id="field_{{ $index }}" 
                                                    wire:model="data.{{ $field['label'] }}"
                                                    class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 bg-transparent dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-base transition-all duration-300 hover:border-emerald-300 px-5 py-4"
                                                    placeholder="{{ $field['type'] == 'date' ? '' : 'Ketik ' . strtolower($field['label']) . ' Anda di sini...' }}"
                                                    {{ $field['required'] ? 'required' : '' }}
                                                >
                                            @endif
                                    </div>
                                    @error('data.' . $field['label']) 
                                        <div class="flex items-center mt-2 text-red-500 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                @endforeach

                            {{-- CAPTCHA Card --}}
                            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">
                                    Verifikasi Keamanan <span class="text-red-500 ml-0.5">*</span>
                                </label>
                                
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                    <div class="px-5 py-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-600 font-mono text-xl font-bold tracking-widest text-emerald-600 dark:text-emerald-400 select-none flex gap-3 items-center">
                                        <span>{{ $captchaA }}</span>
                                        <span class="text-gray-400">+</span>
                                        <span>{{ $captchaB }}</span>
                                        <span class="text-gray-400">=</span>
                                    </div>
                                    <div class="relative w-full sm:w-32">
                                        <input type="number" wire:model="captchaInput" class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-xl font-bold transition-all text-center py-3" required placeholder="?">
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                        Masukkan hasil penjumlahan.
                                    </div>
                                </div>
                                @error('captchaInput') 
                                    <div class="flex items-center mt-3 text-red-500 text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <div class="pt-2">
                                <button 
                                    type="submit" 
                                    class="w-full inline-flex justify-center items-center py-4 px-8 border border-transparent text-base font-bold rounded-xl text-white transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5"
                                    style="background-color: var(--theme-primary);"
                                    wire:loading.attr="disabled"
                                >
                                    <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="submit">Kirim</span>
                                    <span wire:loading wire:target="submit">Memproses...</span>
                                </button>
                                <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-3">Data Anda dienkripsi dan disimpan dengan aman.</p>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
