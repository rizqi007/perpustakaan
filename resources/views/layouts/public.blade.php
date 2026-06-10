<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $site_name ?? config('app.name', 'Perpustakaan Kemenag RI') }}</title>

        @stack('meta')

        @if(isset($site_favicon) && $site_favicon)
            <link rel="icon" href="{{ asset('storage/' . $site_favicon) }}" type="image/png">
        @endif

        <!-- Preconnect and Google Fonts for News Custom Styles -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:wght@300;400;500;600;700;800&family=Oswald:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:wght@300;400;500;600;700;800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Fonts (dynamically configured from Website Settings, loaded via Vite) -->
        @php
            $fontFamily = match($website_settings->website_font ?? 'plus_jakarta_sans') {
                'poppins' => "'Poppins', sans-serif",
                'outfit' => "'Outfit', sans-serif",
                'inter' => "'Inter', sans-serif",
                'verdana' => "Verdana, Geneva, sans-serif",
                default => "'Plus Jakarta Sans', sans-serif",
            };
        @endphp
        <style>
            :root {
                --font-primary: {!! $fontFamily !!};
            }
            body { 
                font-family: var(--font-primary); 
            }
        </style>

        <!-- Flatpickr Date Picker -->
        <link rel="stylesheet" href="{{ asset('vendor/flatpickr/css/flatpickr.min.css') }}">
        <script src="{{ asset('vendor/flatpickr/js/flatpickr.min.js') }}"></script>
        <style>
            .flatpickr-calendar {
                border-radius: 16px !important;
                box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
                border: 1px solid #e5e7eb !important;
                font-family: var(--font-primary) !important;
                overflow: hidden;
            }
            .flatpickr-months {
                background: linear-gradient(135deg, #059669, #0d9488) !important;
                border-radius: 16px 16px 0 0 !important;
                padding: 8px 0 !important;
            }
            .flatpickr-months .flatpickr-month {
                color: white !important;
                fill: white !important;
                height: 40px !important;
            }
            .flatpickr-current-month {
                color: white !important;
                font-weight: 700 !important;
                font-size: 1.05rem !important;
            }
            .flatpickr-current-month .flatpickr-monthDropdown-months { 
                background: transparent !important; 
                color: white !important;
                font-weight: 700 !important;
            }
            .flatpickr-current-month input.cur-year { color: white !important; font-weight: 700 !important; }
            .flatpickr-months .flatpickr-prev-month, 
            .flatpickr-months .flatpickr-next-month { 
                fill: white !important; 
                color: white !important; 
            }
            .flatpickr-months .flatpickr-prev-month svg, 
            .flatpickr-months .flatpickr-next-month svg { 
                fill: white !important; 
            }
            .flatpickr-months .flatpickr-prev-month:hover, 
            .flatpickr-months .flatpickr-next-month:hover { 
                color: #d1fae5 !important; 
            }
            .flatpickr-months .flatpickr-prev-month:hover svg, 
            .flatpickr-months .flatpickr-next-month:hover svg { 
                fill: #d1fae5 !important; 
            }
            span.flatpickr-weekday { 
                color: #059669 !important; 
                font-weight: 700 !important; 
                font-size: 0.8rem !important;
            }
            .flatpickr-day { 
                border-radius: 10px !important; 
                font-weight: 500 !important;
            }
            .flatpickr-day:hover { 
                background: #d1fae5 !important; 
                border-color: #d1fae5 !important; 
                color: #065f46 !important;
            }
            .flatpickr-day.selected, 
            .flatpickr-day.selected:hover { 
                background: #059669 !important; 
                border-color: #059669 !important; 
                color: white !important;
                box-shadow: 0 4px 12px rgba(5,150,105,0.4) !important;
            }
            .flatpickr-day.today { 
                border-color: #059669 !important; 
                color: #059669 !important;
            }
            .flatpickr-day.today:hover { 
                background: #059669 !important; 
                color: white !important;
            }
            .flatpickr-innerContainer { padding: 8px !important; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 dark:bg-gray-900 dark:text-gray-100 flex flex-col min-h-screen">
        @livewireScripts
        <x-loading-screen :site_name="$site_name ?? null" :site_logo="$site_logo ?? null" />

        <!-- Floating Navbar -->
        @if(!request()->routeIs('buku.tamu') && !request()->routeIs('daftar-hadir.show') && !request()->routeIs('daftar.anggota') && !request()->routeIs('kartu.anggota'))
        <nav x-data="{ open: false, scrolled: false }" 
             @scroll.window="scrolled = (window.pageYOffset > 20)"
             class="fixed z-50 top-0 left-0 w-full"
             :class="scrolled ? 'py-0' : 'py-3 md:py-4'" 
             style="transition: padding 0.3s ease;">
            
            <div class="mx-auto transition-all duration-300"
                 :class="scrolled ? 'max-w-full px-0' : 'max-w-[95%] px-3 md:px-6'">
              <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 transition-all duration-300"
                   :class="scrolled ? 'rounded-none shadow-md border-x-0 border-t-0' : 'rounded-full shadow-2xl'">
                
                <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="relative flex justify-between h-20 items-center">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                                @if(isset($site_logo) && $site_logo)
                                    <img src="{{ asset('storage/' . $site_logo) }}" alt="Logo" class="w-10 h-10 object-contain">
                                @else
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                                @endif
                                <div class="flex flex-col">
                                    <span class="font-extrabold text-lg leading-tight text-gray-900 dark:text-white tracking-wide uppercase">{{ $site_name }}</span>
                                    @php
                                        $pageLabel = match(true) {
                                            request()->routeIs('landing') => null,
                                            request()->routeIs('tentang.profil') => 'Profil',
                                            request()->routeIs('tentang.sejarah') => 'Sejarah',
                                            request()->routeIs('berita.index') => 'Berita',
                                            request()->routeIs('berita.show') => 'Berita / Detail',
                                            request()->routeIs('contact') => 'Hubungi Kami',
                                            request()->routeIs('isbn.index') => 'ISBN',
                                            request()->routeIs('isbn.create') => 'Pengajuan ISBN',
                                            request()->routeIs('form.show') => 'Formulir',
                                            request()->routeIs('form.index') => 'Formulir',
                                            request()->routeIs('login') => 'Login',
                                            request()->routeIs('register') => 'Register',
                                            request()->routeIs('layanan.*') => 'Layanan',
                                            default => null,
                                        };
                                    @endphp
                                    @if($pageLabel)
                                        <span class="text-[10px] font-semibold tracking-wider text-emerald-600">Beranda / {{ $pageLabel }}</span>
                                    @else
                                        <span class="text-[10px] font-medium text-gray-500 tracking-wider">KEMENTERIAN AGAMA RI</span>
                                    @endif
                                </div>
                            </a>
                        </div>

                        <!-- Navigation Links (Center) -->
                        <div class="hidden md:flex md:flex-1 md:items-center md:justify-center md:space-x-3">
                            @foreach($navigation_menus as $menu)
                                @if($menu->activeChildren->count() > 0)
                                    {{-- Dropdown Menu Level 1 --}}
                                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                        <button class="flex items-center px-3 py-2 text-sm font-semibold text-gray-700 hover:text-emerald-600 transition {{ $menu->route_name && request()->routeIs($menu->route_name . '*') ? 'text-emerald-600' : '' }}">
                                            {{ $menu->label }}
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        
                                        {{-- Dropdown Menu Level 2 (Rata Kiri, Overflow-visible) --}}
                                        <div x-show="open"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl ring-1 ring-emerald-100 overflow-visible py-1 z-50">
                                            <div class="h-1 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-t-xl"></div>
                                            <div class="py-1">
                                                @foreach($menu->activeChildren as $child)
                                                    @if($child->activeChildren->count() > 0)
                                                        {{-- Level 2 Item WITH Children (Level 3) --}}
                                                        <div class="relative group/sub" x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                                            <a href="{{ $child->resolved_url }}" class="flex items-center justify-between gap-2 px-4 py-2.5 text-sm text-gray-600 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-700 transition-all duration-150" @if($child->open_in_new_tab) target="_blank" @endif>
                                                                <div class="flex items-center gap-2">
                                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 opacity-0 group-hover/sub:opacity-100 transition-opacity"></span>
                                                                    {{ $child->label }}
                                                                </div>
                                                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover/sub:text-emerald-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                            </a>
                                                            
                                                            {{-- Dropdown Menu Level 3 (Kekanan, Overflow-visible) --}}
                                                            <div x-show="subOpen"
                                                                x-transition:enter="transition ease-out duration-150"
                                                                x-transition:enter-start="opacity-0 scale-95"
                                                                x-transition:enter-end="opacity-100 scale-100"
                                                                x-transition:leave="transition ease-in duration-100"
                                                                x-transition:leave-start="opacity-100 scale-100"
                                                                x-transition:leave-end="opacity-0 scale-95"
                                                                class="absolute left-full top-0 ml-1 w-56 bg-white rounded-xl shadow-xl ring-1 ring-emerald-100 overflow-visible py-1 z-50">
                                                                <div class="h-1 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-t-xl"></div>
                                                                <div class="py-1">
                                                                    @foreach($child->activeChildren as $grandChild)
                                                                        <a href="{{ $grandChild->resolved_url }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-700 transition-all duration-150" @if($grandChild->open_in_new_tab) target="_blank" @endif>
                                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                                                            {{ $grandChild->label }}
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{-- Level 2 Item WITHOUT Children --}}
                                                        <a href="{{ $child->resolved_url }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-700 transition-all duration-150" @if($child->open_in_new_tab) target="_blank" @endif>
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                                            {{ $child->label }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Simple Link --}}
                                    <a href="{{ $menu->resolved_url }}" class="px-3 py-2 text-sm font-semibold text-gray-700 hover:text-emerald-600 transition {{ $menu->route_name && request()->routeIs($menu->route_name . '*') ? 'text-emerald-600' : '' }}" @if($menu->open_in_new_tab) target="_blank" @endif>
                                        {{ $menu->label }}
                                    </a>
                                @endif
                            @endforeach
                        </div>


                        <!-- Right Side: Search & Auth -->
                        <div class="hidden md:flex items-center gap-4">
                            <!-- Login Button (Replaces Search) -->
                            <div class="hidden lg:flex items-center">
                                @guest('web')
                                    <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full bg-emerald-600 text-white text-sm font-bold hover:bg-emerald-700 transition shadow-lg hover:shadow-emerald-500/30">
                                        Log in
                                    </a>
                                @endguest
                            </div>
                            
                            <!-- Auth Link (Icon only or Text) -->
                            @auth('web')
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold mr-2">
                                            {{ substr(Auth::guard('web')->user()->name, 0, 1) }}
                                        </div>
                                        <div class="hidden lg:block">{{ Auth::guard('web')->user()->name }}</div>
                                        <svg class="ml-1 fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                         x-transition
                                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden py-1 z-50">
                                        @if(Auth::guard('web')->user()->hasAdminAccess())
                                            <a href="{{ url('/admin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600">Dashboard</a>
                                        @endif
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600">Log Out</button>
                                        </form>
                                    </div>
                                </div>
                            {{-- @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">Log in</a>
                                <a href="{{ route('register') }}" class="ml-4 px-4 py-2 rounded-full bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">Register</a> --}}
                            @endauth('web')
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center md:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" 
                 x-transition
                 class="md:hidden mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mx-4">
                <div class="pt-2 pb-3 space-y-1">
                    @foreach($navigation_menus as $menu)
                        @if($menu->activeChildren->count() > 0)
                            <div x-data="{ subOpen: false }">
                                <button @click="subOpen = !subOpen" class="flex items-center justify-between w-full px-4 py-2 text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600">
                                    {{ $menu->label }}
                                    <svg class="w-4 h-4 transition-transform" :class="subOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="subOpen" x-transition class="pl-4 space-y-1">
                                    @foreach($menu->activeChildren as $child)
                                        @if($child->activeChildren->count() > 0)
                                            <div x-data="{ subSubOpen: false }">
                                                <button @click="subSubOpen = !subSubOpen" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-600 hover:bg-emerald-50 hover:text-emerald-600">
                                                    {{ $child->label }}
                                                    <svg class="w-3.5 h-3.5 transition-transform" :class="subSubOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                </button>
                                                <div x-show="subSubOpen" x-transition class="pl-4 space-y-1">
                                                    @foreach($child->activeChildren as $grandChild)
                                                        <a href="{{ $grandChild->resolved_url }}" class="block px-4 py-2 text-xs font-medium text-gray-500 hover:bg-emerald-50 hover:text-emerald-600" @if($grandChild->open_in_new_tab) target="_blank" @endif>{{ $grandChild->label }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <a href="{{ $child->resolved_url }}" class="block px-4 py-2 text-sm font-medium text-gray-600 hover:bg-emerald-50 hover:text-emerald-600" @if($child->open_in_new_tab) target="_blank" @endif>{{ $child->label }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->resolved_url }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600" @if($menu->open_in_new_tab) target="_blank" @endif>{{ $menu->label }}</a>
                        @endif
                    @endforeach
                </div>

                <div class="p-4 border-t border-gray-100">
                    @guest('web')
                        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 rounded-lg bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition mb-4">
                            Log in
                        </a>
                    @endguest
                    
                    @auth('web')
                        <div class="flex items-center mb-3">
                             <div class="shrink-0">
                                <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold">
                                    {{ substr(Auth::guard('web')->user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::guard('web')->user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::guard('web')->user()->email }}</div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            @if(Auth::guard('web')->user()->hasAdminAccess())
                                <a href="{{ url('/admin') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-md">
                                    Dashboard
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-md">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    {{-- @else
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('login') }}" class="text-center px-4 py-2 rounded-lg bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition">
                                Log in
                            </a>
                            <a href="{{ route('register') }}" class="text-center px-4 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">
                                Register
                            </a>
                        </div> --}}
                    @endauth('web')
                </div>
            </div>
        </nav>
        @endif

        <!-- Page Content -->
        <main class="flex-grow {{ !request()->routeIs('landing') && !request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('form.show') && !request()->routeIs('form.index') && !request()->routeIs('katalog.*') && !request()->routeIs('buku.tamu') && !request()->routeIs('daftar-hadir.show') && !request()->routeIs('daftar.anggota') && !request()->routeIs('kartu.anggota') ? 'pt-24' : '' }}">
            {{ $slot }}
        </main>

        @if(!request()->routeIs('buku.tamu') && !request()->routeIs('daftar-hadir.show') && !request()->routeIs('daftar.anggota') && !request()->routeIs('kartu.anggota'))
        @include('partials.footer')
        @endif
        
        <x-toast-notification />

    </body>
</html>
