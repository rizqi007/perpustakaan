   <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 border-t border-emerald-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        @if(isset($site_logo) && $site_logo)
                            <img src="{{ asset('storage/' . $site_logo) }}" alt="Logo" class="w-10 h-10 object-contain">
                        @else
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                        @endif
                        <div class="flex flex-col">
                            <span class="font-extrabold text-lg leading-tight text-white tracking-wide uppercase">{{ $site_name ?? config('app.name') }}</span>
                            <span class="text-[10px] font-medium text-gray-400 tracking-wider">KEMENTERIAN AGAMA RI</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-4">
                        {{ $site_description ?? 'Perpustakaan Digital Kementerian Agama RI menyediakan akses ke berbagai koleksi digital dan layanan perpustakaan.' }}
                    </p>
                    <div class="flex space-x-4">
                        @if(isset($website_settings) && $website_settings->facebook_url)
                            <a href="{{ $website_settings->facebook_url }}" target="_blank" class="text-gray-400 hover:text-white transition">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                        @endif
                        @if(isset($website_settings) && $website_settings->twitter_url)
                            <a href="{{ $website_settings->twitter_url }}" target="_blank" class="text-gray-400 hover:text-white transition">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                            </a>
                        @endif
                        @if(isset($website_settings) && $website_settings->instagram_url)
                            <a href="{{ $website_settings->instagram_url }}" target="_blank" class="text-gray-400 hover:text-white transition">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465 1.067-.047 1.407-.06 4.123-.06h.08zm-4.71 1.95c-1.077.049-1.769.225-2.224.596a2.956 2.956 0 00-1.068 1.069c-.371.455-.547 1.147-.596 2.223-.05 1.09-.06 1.425-.06 4.155v.068c0 2.73.01 3.064.06 4.155.049 1.076.225 1.768.596 2.224a2.956 2.956 0 001.069 1.068c.455.371 1.147.547 2.223.596 1.09.05 1.425.06 4.155.06h.068c2.73 0 3.064-.01 4.155-.06 1.076-.049 1.768-.225 2.224-.596a2.956 2.956 0 001.068-1.069c.371-.455.547-1.147.596-2.223.05-1.09.06-1.425.06-4.155v-.068c0-2.73-.01-3.064-.06-4.155-.049-1.076-.225-1.768-.596-2.224a2.956 2.956 0 00-1.069-1.068c-.455-.371-1.147-.547-2.223-.596-1.09-.05-1.425-.06-4.155-.06H7.605zm4.71 3.59a4.57 4.57 0 110 9.14 4.57 4.57 0 010-9.14zM12.315 9.043a2.972 2.972 0 100 5.944 2.972 2.972 0 000-5.944zm6.815-4.482a1.065 1.065 0 110 2.13 1.065 1.065 0 010-2.13z" clip-rule="evenodd" /></svg>
                            </a>
                        @endif
                        @if(isset($website_settings) && $website_settings->youtube_url)
                                <a href="{{ $website_settings->youtube_url }}" target="_blank" class="text-gray-400 hover:text-white transition">
                                <span class="sr-only">YouTube</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.254.418-4.813a2.503 2.503 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" /></svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4 uppercase tracking-wider text-sm">Layanan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/layanan/katalog-online" class="hover:text-emerald-400 transition">Katalog Online</a></li>
                        <li><a href="/layanan/e-resources" class="hover:text-emerald-400 transition">E-Resources</a></li>
                        <li><a href="/layanan/keanggotaan" class="hover:text-emerald-400 transition">Keanggotaan</a></li>
                        <li><a href="/layanan/usul-buku" class="hover:text-emerald-400 transition">Usul Buku</a></li>
                    </ul>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4 uppercase tracking-wider text-sm">Informasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/tentang/profil-balai" class="hover:text-emerald-400 transition">Profil Balai</a></li>
                        <li><a href="/tentang/sejarah" class="hover:text-emerald-400 transition">Sejarah</a></li>
                        <li><a href="/berita" class="hover:text-emerald-400 transition">Berita & Artikel</a></li>
                        <li><a href="/hubungi-kami" class="hover:text-emerald-400 transition">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                <h4 class="text-white font-semibold mb-4 uppercase tracking-wider text-sm">Kontak</h4>
                    @if(isset($contactInfo) && $contactInfo)
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ $contactInfo->address }}</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-6 h-6 text-emerald-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>(021) 3811779</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-6 h-6 text-emerald-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>perpustakaan@kemenag.go.id</span>
                            </li>
                        </ul>
                    @else
                        <p class="text-gray-500 text-sm">Informasi kontak belum tersedia.</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-gray-800 text-center">
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} {{ $site_name ?? config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>