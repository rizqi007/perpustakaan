<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Layanan Perpustakaan</h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Kami menyediakan berbagai layanan untuk mendukung kebutuhan informasi dan literasi Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($layanans as $layanan)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
                    <div class="relative h-48 overflow-hidden">
                        @if($layanan->image)
                            <img src="{{ asset('storage/' . $layanan->image) }}" alt="{{ $layanan->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ $layanan->url ?? '#' }}" class="bg-white text-indigo-600 px-4 py-2 rounded-full font-bold">Akses Layanan</a>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $layanan->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $layanan->description ?? 'Nikmati layanan terbaik dari kami.' }}</p>
                        <a href="{{ $layanan->url ?? '#' }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline flex items-center">
                            Selengkapnya <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
