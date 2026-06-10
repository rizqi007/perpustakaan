<section id="testimoni" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center mb-4">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="h-8 w-0.5 bg-green-600 mr-3"></div>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800">
                    TESTIMONI 
                </h2>
            </div>
            <p class="text-base text-gray-700 max-w-3xl mx-auto leading-relaxed font-medium">
               Testimoni dari pengunjung perpustakaan
            </p>
            <div class="w-16 h-1 bg-green-600 mx-auto mt-4"></div>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
            @forelse($testimonis as $testimoni)
                @php
                    $youtubeEmbedUrl = null;
                    $hasLocalVideo = !empty($testimoni->video);
                    $hasYouTubeVideo = false;
                    
                    // Cek apakah ada YouTube URL
                    if ($testimoni->youtube_url) {
                        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
                        if (preg_match($pattern, $testimoni->youtube_url, $match)) {
                            $youtubeEmbedUrl = 'https://www.youtube.com/embed/' . $match[1];
                            $hasYouTubeVideo = true;
                        }
                    }
                    
                    // Prioritas: Video lokal > YouTube > Text only
                    $displayType = $hasLocalVideo ? 'local_video' : ($hasYouTubeVideo ? 'youtube_video' : 'text');
                @endphp

                <article class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 p-6 h-full flex flex-col group">
                    @if($displayType === 'local_video')
                        <!-- Local Video Testimonial -->
                        @php
                            $videoPath = 'storage/' . $testimoni->video;
                            $videoUrl = asset($videoPath);
                            $videoExtension = strtolower(pathinfo($testimoni->video, PATHINFO_EXTENSION));
                        @endphp
                        
                        <div class="relative mb-4">
                            <!-- Video Badge -->
                            <div class="absolute top-3 left-3 z-10">
                                <span class="inline-flex items-center px-2 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                                    </svg>
                                    VIDEO LOKAL
                                </span>
                            </div>
                            
                            <!-- Video Container - Container akan menyesuaikan aspect ratio video -->
                            <div class="rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
                                <video
                                    class="w-full h-auto"
                                    style="display: block; max-height: 500px; object-fit: contain;"
                                    controls
                                    preload="metadata"
                                    poster="{{ $testimoni->photo ? asset('storage/' . $testimoni->photo) : '' }}"
                                    data-video-src="{{ $videoUrl }}"
                                    onloadstart="console.log('Video loading started')"
                                    oncanplay="console.log('Video can start playing')"
                                    onerror="console.error('Video error:', this.error)">
                                    
                                    @if($videoExtension === 'mp4')
                                        <source src="{{ $videoUrl }}" type="video/mp4">
                                    @elseif($videoExtension === 'webm')
                                        <source src="{{ $videoUrl }}" type="video/webm">
                                    @elseif($videoExtension === 'ogg')
                                        <source src="{{ $videoUrl }}" type="video/ogg">
                                    @elseif($videoExtension === 'avi')
                                        <source src="{{ $videoUrl }}" type="video/avi">
                                    @elseif($videoExtension === 'mov')
                                        <source src="{{ $videoUrl }}" type="video/quicktime">
                                    @else
                                        <source src="{{ $videoUrl }}" type="video/mp4">
                                    @endif
                                    
                                    <!-- Fallback message -->
                                    <div class="flex items-center justify-center h-full bg-gray-100">
                                        <div class="text-center p-4">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.312 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600">Browser Anda tidak mendukung format video ini</p>
                                            <a href="{{ $videoUrl }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm underline">
                                                Download Video
                                            </a>
                                        </div>
                                    </div>
                                </video>
                            </div>
                        </div>

                        <!-- Quote Section untuk Video Lokal -->
                        <div class="flex-grow mb-4">
                            <div class="relative pl-4">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500 rounded-full"></div>
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-2 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                    </svg>
                                    <p class="text-gray-700 text-sm leading-relaxed italic">
                                        {{ $testimoni->quote }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Author Info untuk Video Lokal -->
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">{{ $testimoni->name }}</p>
                                    @if($testimoni->institution)
                                        <p class="text-xs text-gray-500">{{ $testimoni->institution }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center text-xs text-green-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    <span>Terverifikasi</span>
                                </div>
                            </div>
                        </div>

                    @elseif($displayType === 'youtube_video')
                        <!-- YouTube Video Testimonial -->
                        <div class="relative mb-4">
                            <!-- Video Badge -->
                            <div class="absolute top-3 left-3 z-10">
                                <span class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                                    </svg>
                                    YOUTUBE
                                </span>
                            </div>
                            
                            <!-- YouTube Video Container - Fixed 16:9 aspect ratio -->
                            <div class="aspect-video rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
                                <iframe
                                    class="w-full h-full"
                                    src="{{ $youtubeEmbedUrl }}"
                                    title="Video testimoni {{ $testimoni->name }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>

                        <!-- Quote Section untuk YouTube -->
                        <div class="flex-grow mb-4">
                            <div class="relative pl-4">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500 rounded-full"></div>
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-2 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                    </svg>
                                    <p class="text-gray-700 text-sm leading-relaxed italic">
                                        {{ $testimoni->quote }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Author Info untuk YouTube -->
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">{{ $testimoni->name }}</p>
                                    @if($testimoni->institution)
                                        <p class="text-xs text-gray-500">{{ $testimoni->institution }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center text-xs text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    <span>Terverifikasi</span>
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- Text-only Testimonial -->
                        <div class="flex-grow">
                            <div class="flex items-start space-x-4 mb-4">
                                @if($testimoni->photo)
                                    <!-- Photo with Government Frame -->
                                    <div class="flex-shrink-0 relative">
                                        <div class="w-16 h-16 rounded-full border-3 border-green-600 p-1 bg-white">
                                            <img
                                                src="{{ asset('storage/' . $testimoni->photo) }}"
                                                alt="{{ $testimoni->name }}"
                                                class="w-full h-full rounded-full object-cover"
                                                loading="lazy">
                                        </div>
                                        <!-- Verification Badge -->
                                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-600 rounded-full flex items-center justify-center border-2 border-white">
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <!-- Default Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center border-3 border-green-600">
                                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @endif

                                <!-- Quote Content -->
                                <div class="flex-1">
                                    <div class="relative pl-4">
                                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500 rounded-full"></div>
                                        <div class="flex items-start">
                                            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-2 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                            </svg>
                                            <p class="text-gray-700 text-sm leading-relaxed italic">
                                                {{ $testimoni->quote }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Author Info untuk Text -->
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">{{ $testimoni->name }}</p>
                                    @if($testimoni->institution)
                                        <p class="text-xs text-gray-500">{{ $testimoni->institution }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center text-xs text-green-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    <span>Terverifikasi</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </article>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
                        <!-- Official Icon -->
                        <div class="w-20 h-20 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z"></path>
                            </svg>
                        </div>
                        
                        <!-- Official Message -->
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">
                            BELUM ADA TESTIMONI MASUK
                        </h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-2 max-w-md mx-auto">
                            Feedback dan testimoni dari masyarakat akan ditampilkan di halaman ini setelah mendapat persetujuan.
                        </p>
                        <p class="text-gray-500 text-xs">
                            Kami menghargai setiap masukan dari masyarakat.
                        </p>

                        <!-- Official Badge -->
                        <div class="inline-flex items-center mt-6 px-3 py-1 bg-green-50 border border-green-200 rounded-full">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-xs font-medium text-green-700">TESTIMONI TERVERIFIKASI</span>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>