<div>
    {{-- Hero Header --}}
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-emerald-900 pt-32 pb-16 md:pb-20 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-72 h-72 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-72 h-72 bg-teal-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        <div class="relative max-w-md mx-auto px-4 text-center">
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Masuk</h1>
            <p class="mt-2 text-emerald-300 text-sm">Masuk ke akun Anda untuk mengakses formulir</p>
        </div>
    </section>

    {{-- Login Form --}}
    <section class="relative -mt-8 pb-16">
        <div class="max-w-md mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h2 class="text-lg font-bold text-white">Login</h2>
                    </div>
                </div>

                <form wire:submit="login" class="p-6 space-y-5">
                    @if (session()->has('success_register'))
                        <div class="p-4 mb-2 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-950/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-900/50 flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <span class="font-bold block text-sm">Registrasi Berhasil!</span>
                                <p class="mt-1 text-xs opacity-90 leading-relaxed">{{ session('success_register') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session()->has('warning_validation'))
                        <div class="p-4 mb-2 text-sm text-amber-800 rounded-xl bg-amber-50 dark:bg-amber-950/30 dark:text-amber-300 border border-amber-100 dark:border-amber-900/50 flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <div>
                                <span class="font-bold block text-sm">Akun Belum Aktif!</span>
                                <p class="mt-1 text-xs opacity-90 leading-relaxed">{{ session('warning_validation') }}</p>
                            </div>
                        </div>
                    @endif

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

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" wire:model="password" placeholder="Masukkan password"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm">
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                            </div>
                        </div>
                        @error('password') <p class="mt-1 text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                    </div>

                    {{-- Captcha --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Captcha <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="flex-shrink-0 bg-gray-900 text-white px-5 py-3 rounded-xl font-mono text-2xl font-bold tracking-[0.5em] select-none relative overflow-hidden">
                                <div class="absolute inset-0 opacity-20">
                                    <div class="absolute top-0 left-0 w-full h-px bg-gray-500 transform rotate-12 translate-y-3"></div>
                                    <div class="absolute top-0 left-0 w-full h-px bg-gray-500 transform -rotate-6 translate-y-6"></div>
                                    <div class="absolute top-0 left-0 w-full h-px bg-gray-500 transform rotate-3 translate-y-9"></div>
                                </div>
                                <span class="relative">{{ $this->getCaptchaCode() }}</span>
                            </div>
                            <button type="button" wire:click="refreshCaptcha" class="flex-shrink-0 w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition" title="Refresh Captcha">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </button>
                        </div>
                        <input type="text" wire:model="captcha_input" placeholder="Masukkan 3 huruf di atas" maxlength="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm uppercase tracking-widest font-mono">
                        @error('captcha_input') <p class="mt-1 text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-bold text-sm tracking-wide shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:from-emerald-700 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 transform hover:-translate-y-0.5"
                        wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-not-allowed">
                        <span wire:loading.remove>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        </span>
                        <span wire:loading>
                            <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </span>
                        <span wire:loading.remove>Masuk</span>
                        <span wire:loading>Memproses...</span>
                    </button>

                    {{-- Register Link --}}
                    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold">Daftar Sekarang</a>
                    </p>
                </form>
            </div>
        </div>
    </section>
</div>
