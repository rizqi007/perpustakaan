<section id="layanan" class="py-10 bg-gradient-to-br from-gray-50 to-green-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-600 to-green-700 rounded-xl flex items-center justify-center mr-2 shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2L3 7v11h4v-6h6v6h4V7l-7-5z"/>
                    </svg>
                </div>
                <h2 class="text-xl md:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-800 to-green-800 bg-clip-text text-transparent">
                    LAYANAN PERPUSTAKAAN
                </h2>
            </div>
            <p class="text-sm text-gray-600 max-w-2xl mx-auto">
                Akses mudah dan cepat untuk berbagai layanan digital dalam satu platform terpadu
            </p>
        </div>

        <!-- Services Grid -->
        <div class="max-w-7xl mx-auto">
            @if($layanans->count() > 0)
                <!-- Grid Container -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($layanans as $layanan)
                        <div class="group">
                            <a href="{{ $layanan->url }}" target="_blank" class="block h-full">
                                <!-- Card Container -->
                                <div class="relative bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-5 flex items-center gap-4 border border-gray-100 hover:border-green-200 overflow-hidden group-hover:-translate-y-0.5">
                                    
                                    <!-- Icon Section -->
                                    <div class="flex-shrink-0 relative z-10">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-105">
                                            <img 
                                                src="{{ asset('storage/' . $layanan->image) }}" 
                                                alt="{{ $layanan->name }}"
                                                class="w-7 h-7 object-contain transition-all duration-300"
                                            >
                                        </div>
                                    </div>
                                    
                                    <!-- Service Name -->
                                    <div class="flex-grow relative z-10">
                                        <h3 class="font-semibold text-base text-gray-900 group-hover:text-green-700 transition-colors duration-300 line-clamp-2">
                                            {{ $layanan->name }}
                                        </h3>
                                    </div>

                                    <!-- Hover Background Effect -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-green-50/0 to-green-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="flex justify-center">
                    <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center max-w-md shadow-lg">
                        <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-green-50 border border-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-800 mb-3">
                            LAYANAN SEDANG DALAM PENGEMBANGAN
                        </h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-2">
                            Layanan digital sedang dalam tahap pengembangan untuk memberikan pelayanan terbaik kepada masyarakat.
                        </p>
                        <p class="text-gray-500 text-xs">
                            Informasi lebih lanjut akan diumumkan melalui saluran resmi kami.
                        </p>

                        <div class="inline-flex items-center mt-6 px-4 py-2 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-full shadow-sm">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                            <span class="text-xs font-semibold text-green-700">RESMI PEMERINTAH</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>