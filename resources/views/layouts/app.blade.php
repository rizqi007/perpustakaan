<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $site_name ?? config('app.name', 'Laravel') }}</title>

        @if(isset($site_favicon) && $site_favicon)
            <link rel="icon" href="{{ asset('storage/' . $site_favicon) }}" type="image/png">
        @endif
        
        <!-- Preconnect and Google Fonts for News Custom Styles -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:wght@300;400;500;600;700;800&family=Oswald:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:wght@300;400;500;600;700;800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Fonts -->
        <!-- Fonts (now loaded via Vite) -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                --font-sans: {!! $fontFamily !!} !important;
                font-family: var(--font-sans) !important;
            }
            body, button, input, select, textarea {
                font-family: var(--font-sans) !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col md:flex-row bg-gray-100 dark:bg-gray-900">
            <livewire:layout.sidebar />

            <div class="flex-1 flex flex-col min-h-screen">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900">
                    {{ $slot }}
                </main>
            </div>
        </div>
        <!-- Quill.js -->
        <link href="{{ asset('vendor/css/quill.snow.css') }}" rel="stylesheet">
        <script src="{{ asset('vendor/js/quill.js') }}"></script>
    </body>
</html>
