@push('meta')
    @php
        $description = '';
        if (!empty($berita->content)) {
            $data = json_decode($berita->content);
            if (json_last_error() === JSON_ERROR_NONE && isset($data->blocks)) {
                // Extract text from blocks if JSON
                foreach ($data->blocks as $block) {
                    if (isset($block->data->text)) {
                        $description .= $block->data->text . ' ';
                    }
                    if (strlen($description) > 200) break;
                }
            } else {
                // Standard HTML
                $description = strip_tags($berita->content);
            }
        }
        $description = \Illuminate\Support\Str::limit(trim($description), 150);
    @endphp
    <meta property="og:title" content="{{ $berita->title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ asset('storage/' . $berita->image) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    <meta name="twitter:card" content="summary_large_image">
@endpush

<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    @if($berita->image)
                        <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" class="w-full h-auto object-cover max-h-[500px]">
                    @endif
                    
                    <div class="p-8">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4 space-x-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $berita->created_at->translatedFormat('d F Y') }}
                            </span>
                             <!-- Add author if available in model -->
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">{{ $berita->title }}</h1>

                        <div class="prose dark:prose-invert max-w-none text-gray-800 dark:text-gray-200 leading-relaxed space-y-4">
                            @php
                                $isJson = false;
                                $blocks = [];
                                if (!empty($berita->content)) {
                                    $data = json_decode($berita->content);
                                    if (json_last_error() === JSON_ERROR_NONE && isset($data->blocks)) {
                                        $isJson = true;
                                        $blocks = $data->blocks;
                                    }
                                }
                            @endphp

                            @if($isJson)
                                @foreach($blocks as $block)
                                    @if($block->type === 'header')
                                        <h{{ $block->data->level }} class="font-bold mb-2">{{ $block->data->text }}</h{{ $block->data->level }}>
                                    @elseif($block->type === 'paragraph')
                                        <p class="mb-4">{!! $block->data->text !!}</p>
                                    @elseif($block->type === 'list')
                                        @if($block->data->style === 'ordered')
                                            <ol class="list-decimal pl-5 mb-4">
                                                @foreach($block->data->items as $item) <li>{!! $item !!}</li> @endforeach
                                            </ol>
                                        @else
                                            <ul class="list-disc pl-5 mb-4">
                                                @foreach($block->data->items as $item) <li>{!! $item !!}</li> @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                {!! $berita->content !!}
                            @endif
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3 space-y-8">
                <!-- Recent Posts Widget -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">Berita Terbaru</h3>
                    <div class="space-y-4">
                        @foreach($recent_posts as $post)
                            <div class="flex gap-4">
                                <a href="{{ route('berita.show', $post->slug ?? $post->id) }}" class="flex-shrink-0 w-20 h-20 rounded-md overflow-hidden bg-gray-100">
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-110 transition-transform">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </a>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2 hover:text-indigo-600 transition-colors">
                                        <a href="{{ route('berita.show', $post->slug ?? $post->id) }}">{{ $post->title }}</a>
                                    </h4>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">{{ $post->created_at->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
