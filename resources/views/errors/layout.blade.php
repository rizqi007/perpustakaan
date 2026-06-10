<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name', 'Perpustakaan Kemenag RI') }}</title>

    <!-- Dynamic Fonts and Vite Styles -->
    @php
        try {
            $settings = \App\Models\WebsiteSetting::first();
            $fontVal = $settings->website_font ?? 'plus_jakarta_sans';
        } catch (\Exception $e) {
            $fontVal = 'plus_jakarta_sans';
        }
        $fontFamily = match($fontVal) {
            'poppins' => "'Poppins', sans-serif",
            'outfit' => "'Outfit', sans-serif",
            'inter' => "'Inter', sans-serif",
            'verdana' => "Verdana, Geneva, sans-serif",
            default => "'Plus Jakarta Sans', sans-serif",
        };
    @endphp
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --font-primary: {!! $fontFamily !!};
        }
        body { 
            font-family: var(--font-primary) !important; 
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900 antialiased font-sans relative overflow-hidden">
    
    <!-- Background Decorator -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <!-- Grid pattern -->
        <svg class="absolute inset-0 h-full w-full stroke-gray-200/50 dark:stroke-gray-800/30 [mask-image:radial-gradient(100%_100%_at_center,white,transparent)]" aria-hidden="true">
            <defs>
                <pattern id="grid-pattern" width="40" height="40" x="50%" y="-1" patternUnits="userSpaceOnUse">
                    <path d="M.5 40V.5H40" fill="none" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#grid-pattern)" />
        </svg>
        
        <!-- Glowing gradient orbs -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 -z-10 transform-gpu blur-3xl opacity-20 dark:opacity-30" aria-hidden="true">
            <div class="aspect-[1155/678] w-[50rem] bg-gradient-to-tr from-emerald-400 via-teal-500 to-emerald-600" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="flex-grow flex items-center justify-center px-6 py-12 sm:py-24 z-10">
        <div class="max-w-xl w-full mx-auto text-center space-y-8">
            
            <!-- Code Header -->
            <div class="relative inline-block">
                <!-- Giant status code -->
                <h1 class="text-8xl sm:text-[10rem] font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 dark:from-emerald-400 dark:to-teal-500 select-none animate-pulse filter drop-shadow-lg leading-none">
                    @yield('code')
                </h1>
                
                <!-- Inner small badge label -->
                <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-white dark:bg-gray-800 border border-emerald-100 dark:border-emerald-950 px-4 py-1 rounded-full shadow-md text-xs font-bold text-emerald-600 dark:text-emerald-400 tracking-widest uppercase">
                    ERROR STATUS
                </div>
            </div>

            <!-- Messages -->
            <div class="space-y-4">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-tight">
                    @yield('title')
                </h2>
                <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400 max-w-md mx-auto leading-relaxed">
                    @yield('message')
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-4">
                <!-- Back to Home -->
                <a href="/" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-xl shadow-lg hover:shadow-emerald-500/20 active:scale-[0.98] transition duration-200">
                    <!-- Home Icon -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Kembali ke Beranda
                </a>
                
                <!-- Go Back -->
                <button onclick="window.history.back()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700/80 text-gray-700 dark:text-gray-200 font-bold rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm active:scale-[0.98] transition duration-200">
                    <!-- Back Arrow Icon -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali Sebelumnya
                </button>
            </div>
            
        </div>
    </div>
</body>
</html>
