<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Apa Kata Mereka</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Testimoni Pengunjung</h2>
            <div class="w-16 h-1.5 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Pendapat mereka tentang layanan dan fasilitas Perpustakaan Kementerian Agama RI.</p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{ activeVideo: null, activeVideoType: null }">
            @foreach($testimonis as $testimoni)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 flex flex-col group h-full">
                    
                    <!-- Media Thumbnail (Top) -->
                    <div class="relative aspect-video bg-gray-100 cursor-pointer overflow-hidden group-hover:opacity-95 transition"
                         @if($testimoni->video || $testimoni->youtube_url)
                            @click="activeVideo = '{{ $testimoni->video ? asset('storage/' . $testimoni->video) : $testimoni->youtube_url }}'; activeVideoType = '{{ $testimoni->video ? 'local' : 'youtube' }}'"
                         @endif
                    >
                        @if($testimoni->photo)
                             <!-- User Uploaded Photo as Thumbnail -->
                            <img src="{{ asset('storage/' . $testimoni->photo) }}" alt="{{ $testimoni->name }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        
                        @elseif($testimoni->youtube_url)
                            <!-- YouTube Thumbnail -->
                            @php
                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $testimoni->youtube_url, $matches);
                                $videoId = $matches[1] ?? null;
                            @endphp
                            @if($videoId)
                                <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <span class="text-xs text-gray-500">Invalid YouTube URL</span>
                                </div>
                            @endif

                        @elseif($testimoni->video)
                             <!-- Local Video Preview (Muted, Object Cover) -->
                            <video class="w-full h-full object-cover" muted proload="metadata">
                                <source src="{{ asset('storage/' . $testimoni->video) }}#t=0.5" type="video/mp4">
                            </video>

                        @else
                            <!-- Fallback Avatar -->
                            <div class="w-full h-full flex items-center justify-center bg-emerald-50 text-emerald-600">
                                <span class="text-4xl font-bold opacity-20">{{ substr($testimoni->name, 0, 1) }}</span>
                            </div>
                        @endif

                        <!-- Play Overlay if Video -->
                        @if($testimoni->video || $testimoni->youtube_url)
                            <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/30 transition">
                                <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center pl-1 shadow-lg transform group-hover:scale-110 transition duration-300">
                                    <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                            <div class="absolute bottom-3 right-3 bg-black/60 text-white text-xs px-2 py-1 rounded backdrop-blur-md">
                                {{ $testimoni->video ? 'Video' : 'YouTube' }}
                            </div>
                        @endif
                    </div>

                    <!-- Content (Bottom) -->
                    <div class="p-6 flex-1 flex flex-col">
                        <!-- Quote -->
                        <div class="mb-6 relative flex-1">
                            <svg class="absolute -top-2 -left-2 w-6 h-6 text-emerald-100 transform -scale-x-100" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                            </svg>
                            <p class="text-gray-600 italic leading-relaxed relative z-10 pl-4 text-sm md:text-base">
                                "{{ Str::limit($testimoni->quote, 150) }}"
                            </p>
                        </div>

                        <!-- User Info -->
                        <div class="flex items-center pt-4 border-t border-gray-100">
                           <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold mr-3 border border-emerald-200">
                                {{ substr($testimoni->name, 0, 1) }}
                           </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm line-clamp-1">{{ $testimoni->name }}</h4>
                                <p class="text-xs text-emerald-600 font-medium line-clamp-1">{{ $testimoni->institution }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Video Modal -->
            <div x-show="activeVideo" 
                 class="fixed inset-0 z-[100] flex items-center justify-center px-4 py-6 sm:px-0"
                 style="display: none;">
                
                <div class="fixed inset-0 transition-opacity" @click="activeVideo = null">
                    <div class="absolute inset-0 bg-gray-900/90 backdrop-blur-sm"></div>
                </div>

                <div class="bg-black rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-4xl sm:w-full relative"
                     @click.stop
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="aspect-video w-full bg-black relative flex items-center justify-center">
                        <template x-if="activeVideoType === 'local'">
                             <video controls autoplay class="w-full h-full max-h-[80vh]">
                                <source :src="activeVideo" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </template>
                        <template x-if="activeVideoType === 'youtube'">
                            <iframe class="w-full h-full" :src="activeVideo + '?autoplay=1'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </template>
                         <button @click="activeVideo = null" class="absolute top-4 right-4 text-white hover:text-gray-300 z-50 bg-black/50 rounded-full p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $testimonis->links('vendor.pagination.kliping') }}
        </div>
    </div>
</div>
