<div>
    {{-- Hero Header --}}
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-emerald-900 pt-32 pb-16 md:pb-20 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-72 h-72 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-72 h-72 bg-teal-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        <div class="relative max-w-md mx-auto px-4 text-center">
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Daftar Akun</h1>
            <p class="mt-2 text-emerald-300 text-sm">Buat akun baru untuk mengakses formulir</p>
        </div>
    </section>

    {{-- Register Form --}}
    <section class="relative -mt-8 pb-16">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                        <h2 class="text-lg font-bold text-white">Register</h2>
                    </div>
                </div>

                <form wire:submit="register" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Left Column --}}
                        <div class="space-y-5">
                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="name" placeholder="Masukkan nama lengkap"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm">
                                @error('name') <p class="mt-1 text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="email" wire:model="email" placeholder="contoh@email.com"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm">
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                </div>
                                @error('email') <p class="mt-1 text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>

                            {{-- Satuan Kerja --}}
                            <div x-data="{
                                open: false,
                                search: '',
                                satkers: [],
                                selected: @entangle('satuan_kerja'),
                                isManual: @entangle('is_manual'),
                                async init() {
                                    try {
                                        const response = await fetch('/data/satkers.json');
                                        this.satkers = await response.json();
                                    } catch (e) {
                                        console.error('Gagal memuat data satker:', e);
                                    }
                                    if (this.selected) {
                                        this.search = this.selected;
                                    }
                                },
                                get filteredSatkers() {
                                    if (!this.search) return this.satkers.slice(0, 15);
                                    const query = this.search.toLowerCase();
                                    return this.satkers.filter(s => s.toLowerCase().includes(query)).slice(0, 15);
                                },
                                selectSatker(val) {
                                    this.selected = val;
                                    this.search = val;
                                    this.open = false;
                                }
                            }" @click.outside="open = false" class="relative">
                                
                                {{-- Dropdown Mode --}}
                                <div x-show="!isManual">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Satuan Kerja <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                            placeholder="Cari atau pilih Satuan Kerja..."
                                            x-model="search"
                                            @focus="open = true"
                                            @input="open = true; selected = ''"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm">
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                                            <button type="button" @click.stop="search = ''; selected = ''; open = true" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none" x-show="search">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                            <button type="button" @click.stop="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none">
                                                <svg class="w-5 h-5 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    {{-- Dropdown List --}}
                                    <div x-show="open" 
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-95"
                                        class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 max-h-60 overflow-y-auto py-1 text-sm">
                                        
                                        {{-- Option: Isi Manual --}}
                                        <button type="button" 
                                            @click="isManual = true; open = false; selected = ''; $wire.set('custom_satuan_kerja', search)"
                                            class="w-full text-left px-4 py-2.5 text-emerald-600 dark:text-emerald-400 font-semibold hover:bg-emerald-50 dark:hover:bg-emerald-950/30 transition flex items-center gap-2 border-b border-gray-100 dark:border-gray-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            <span>Satuan Kerja Tidak Ditemukan? Isi Manual</span>
                                        </button>
                                        
                                        <template x-for="item in filteredSatkers" :key="item">
                                            <button type="button" 
                                                @click="selectSatker(item)"
                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition"
                                                :class="{'bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 font-semibold': selected === item}">
                                                <span x-text="item"></span>
                                            </button>
                                        </template>
                                        
                                        <div class="px-4 py-2 text-gray-400 dark:text-gray-500 text-xs italic text-center" x-show="filteredSatkers.length === 0">
                                            Tidak ditemukan. Klik pilihan "Isi Manual" di atas.
                                        </div>
                                    </div>
                                    
                                    {{-- Helper / Fallback Link --}}
                                    <div class="mt-1 flex justify-end">
                                        <button type="button" @click="isManual = true; selected = ''; $wire.set('custom_satuan_kerja', search)" class="text-xs text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1 font-medium">
                                            <span>Tidak ada dalam daftar? Isi manual</span>
                                        </button>
                                    </div>
                                    
                                    @error('satuan_kerja') <p class="mt-1 text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                                </div>
                                
                                {{-- Manual Mode --}}
                                <div x-show="isManual" style="display: none;">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Satuan Kerja (Manual) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                        wire:model="custom_satuan_kerja" 
                                        placeholder="Masukkan nama Satuan Kerja lengkap"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm">
                                    
                                    {{-- Helper / Return Link --}}
                                    <div class="mt-1 flex justify-end">
                                        <button type="button" @click="isManual = false; $wire.set('custom_satuan_kerja', '')" class="text-xs text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1 font-medium">
                                            <span>Kembali pilih dari daftar dropdown</span>
                                        </button>
                                    </div>
                                    
                                    @error('custom_satuan_kerja') <p class="mt-1 text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Nomor HP --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nomor HP <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="no_hp" placeholder="Masukkan nomor HP aktif"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm">
                                @error('no_hp') <p class="mt-1 text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="space-y-5" x-data="{
                            password: '',
                            password_confirm: '',
                            showPassword: false,
                            showConfirmPassword: false,
                            focusPassword: false,
                            get hasMinLength() { return this.password.length >= 6; },
                            get hasUpperLower() { return /[a-z]/.test(this.password) && /[A-Z]/.test(this.password); },
                            get hasSymbol() { return /[^A-Za-z0-9]/.test(this.password); },
                            get hasNoSeqNumbers() {
                                if (this.password.length < 3) return true;
                                for (let i = 0; i < this.password.length - 2; i++) {
                                    let c1 = this.password.charCodeAt(i);
                                    let c2 = this.password.charCodeAt(i + 1);
                                    let c3 = this.password.charCodeAt(i + 2);
                                    if (c1 >= 48 && c1 <= 57 && c2 >= 48 && c2 <= 57 && c3 >= 48 && c3 <= 57) {
                                        if (c2 === c1 + 1 && c3 === c2 + 1) return false;
                                        if (c2 === c1 - 1 && c3 === c2 - 1) return false;
                                    }
                                }
                                return true;
                            },
                            get isMatching() {
                                return this.password_confirm.length > 0 && this.password === this.password_confirm;
                            },
                            get isNotMatching() {
                                return this.password_confirm.length > 0 && this.password !== this.password_confirm;
                            }
                        }">
                            {{-- Password --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" 
                                        wire:model="password" 
                                        x-model="password"
                                        @focus="focusPassword = true"
                                        @blur="focusPassword = false"
                                        placeholder="Minimal 6 karakter"
                                        class="w-full pl-4 pr-12 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm">
                                    
                                    {{-- Toggle Eye Button --}}
                                    <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none">
                                        {{-- Eye icon (when hidden) --}}
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        {{-- Eye-slash icon (when visible) --}}
                                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                    </button>
                                </div>
                                
                                {{-- Password Rules Indicators --}}
                                <div x-show="focusPassword || password.length > 0"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                                     x-transition:enter-end="opacity-100 transform translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 transform translate-y-0"
                                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                                     class="mt-3 p-3.5 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-800 text-xs space-y-2">
                                    <p class="font-semibold text-gray-500 dark:text-gray-400">Ketentuan Password:</p>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                                        {{-- Rule: Min 6 chars --}}
                                        <div class="flex items-center gap-2 transition" :class="hasMinLength ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-gray-400 dark:text-gray-500'">
                                            <svg class="w-4 h-4 flex-shrink-0 transition" :class="hasMinLength ? 'scale-110' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path x-show="hasMinLength" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                <circle x-show="!hasMinLength" cx="12" cy="12" r="3" fill="currentColor"/>
                                            </svg>
                                            <span>Minimal 6 karakter</span>
                                        </div>
                                        
                                        {{-- Rule: Upper Lower --}}
                                        <div class="flex items-center gap-2 transition" :class="hasUpperLower ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-gray-400 dark:text-gray-500'">
                                            <svg class="w-4 h-4 flex-shrink-0 transition" :class="hasUpperLower ? 'scale-110' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path x-show="hasUpperLower" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                <circle x-show="!hasUpperLower" cx="12" cy="12" r="3" fill="currentColor"/>
                                            </svg>
                                            <span>Huruf besar & kecil (A-Z, a-z)</span>
                                        </div>
                                        
                                        {{-- Rule: Symbol --}}
                                        <div class="flex items-center gap-2 transition" :class="hasSymbol ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-gray-400 dark:text-gray-500'">
                                            <svg class="w-4 h-4 flex-shrink-0 transition" :class="hasSymbol ? 'scale-110' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path x-show="hasSymbol" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                <circle x-show="!hasSymbol" cx="12" cy="12" r="3" fill="currentColor"/>
                                            </svg>
                                            <span>Simbol/karakter unik (!,@,#,dll)</span>
                                        </div>
                                        
                                        {{-- Rule: No Sequential Numbers --}}
                                        <div class="flex items-center gap-2 transition" :class="hasNoSeqNumbers ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-red-500 dark:text-red-400 font-medium'">
                                            <svg class="w-4 h-4 flex-shrink-0 transition" :class="!hasNoSeqNumbers ? 'text-red-500 dark:text-red-400 scale-110' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path x-show="hasNoSeqNumbers" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                <path x-show="!hasNoSeqNumbers" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            <span x-text="hasNoSeqNumbers ? 'Tidak ada angka berurutan' : 'Ada angka berurutan!'"></span>
                                        </div>
                                    </div>
                                </div>
                                @error('password') <p class="mt-1 text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input :type="showConfirmPassword ? 'text' : 'password'" 
                                        wire:model="password_confirmation" 
                                        x-model="password_confirm"
                                        placeholder="Ulangi password"
                                        class="w-full pl-4 pr-20 py-3 rounded-xl border bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 transition text-sm"
                                        :class="{
                                            'border-gray-200 dark:border-gray-600 focus:ring-emerald-500 focus:border-emerald-500': password_confirm.length === 0,
                                            'border-emerald-500 focus:ring-emerald-500 focus:border-emerald-500': isMatching,
                                            'border-red-500 focus:ring-red-500 focus:border-red-500': isNotMatching
                                        }">
                                    
                                    {{-- Indicator Icon & Eye Toggle --}}
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2">
                                        {{-- Match Indicator --}}
                                        <div x-show="password_confirm.length > 0">
                                            <svg x-show="isMatching" class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <svg x-show="isNotMatching" class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        
                                        {{-- Toggle Eye Button --}}
                                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none">
                                            <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Text feedback --}}
                                <div class="mt-1.5 text-xs font-semibold" x-show="password_confirm.length > 0">
                                    <p x-show="isMatching" class="text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        <span>Password cocok</span>
                                    </p>
                                    <p x-show="isNotMatching" class="text-red-500 dark:text-red-400 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        <span>Password tidak cocok</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Surat Tugas --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Upload Surat Tugas <span class="text-red-500">*</span></label>
                                <div class="relative flex items-center justify-center w-full">
                                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                            <p class="mb-1 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                                            <p class="text-xs text-gray-400">PDF, JPG, JPEG, PNG (Maks. 2MB)</p>
                                        </div>
                                        <input type="file" wire:model="surat_tugas" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                    </label>
                                </div>
                                <div wire:loading wire:target="surat_tugas" class="mt-2 text-xs text-gray-500 flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span>Mengunggah file...</span>
                                </div>
                                @if ($surat_tugas)
                                    <div class="mt-2 text-xs text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>File siap diunggah: {{ is_string($surat_tugas) ? basename($surat_tugas) : $surat_tugas->getClientOriginalName() }}</span>
                                    </div>
                                @endif
                                @error('surat_tugas') <p class="mt-1 text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>

                            {{-- Captcha --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Captcha <span class="text-red-500">*</span></label>
                                <div class="flex items-center gap-3">
                                    {{-- Captcha Image & Refresh Button Container --}}
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <div class="bg-gray-900 text-white px-4 py-2.5 rounded-xl font-mono text-xl font-bold tracking-[0.3em] select-none relative overflow-hidden flex items-center justify-center min-w-[90px] text-center">
                                            <div class="absolute inset-0 opacity-20">
                                                <div class="absolute top-0 left-0 w-full h-px bg-gray-500 transform rotate-12 translate-y-3"></div>
                                                <div class="absolute top-0 left-0 w-full h-px bg-gray-500 transform -rotate-6 translate-y-6"></div>
                                                <div class="absolute top-0 left-0 w-full h-px bg-gray-500 transform rotate-3 translate-y-9"></div>
                                            </div>
                                            <span class="relative z-10 pl-1">{{ $this->getCaptchaCode() }}</span>
                                        </div>
                                        <button type="button" wire:click="refreshCaptcha" class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition" title="Refresh Captcha">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        </button>
                                    </div>
                                    
                                    {{-- Input Field --}}
                                    <div class="flex-grow">
                                        <input type="text" wire:model="captcha_input" placeholder="Masukkan 3 huruf" maxlength="3"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm uppercase tracking-widest font-mono text-center">
                                    </div>
                                </div>
                                @error('captcha_input') <p class="mt-1.5 text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Submit & Links --}}
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700 space-y-4">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-bold text-sm tracking-wide shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:from-emerald-700 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 transform hover:-translate-y-0.5"
                            wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-not-allowed">
                            <span wire:loading.remove>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            </span>
                            <span wire:loading>
                                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </span>
                            <span wire:loading.remove>Daftar</span>
                            <span wire:loading>Memproses...</span>
                        </button>

                        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold">Masuk</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
