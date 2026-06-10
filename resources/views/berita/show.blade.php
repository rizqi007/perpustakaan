@extends('layouts.app')

@section('meta')
    <!-- Open Graph Meta Tags for WhatsApp & Social Media -->
    <meta property="og:title" content="{{ $berita->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($berita->content), 200) }}">
    <meta property="og:image" content="{{ asset('storage/' . $berita->image) }}">
    <meta property="og:url" content="{{ route('berita.show', $berita->id) }}">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="Perpustakaan Kemenag RI">
    <meta property="article:published_time" content="{{ $berita->published_at->toIso8601String() }}">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $berita->title }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $berita->image) }}">
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 mt-16 sm:mt-20">
        <div class="grid lg:grid-cols-12 gap-6 lg:gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-8">
                <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                    {{-- Article Header --}}
                    <div class="px-4 sm:px-6 lg:px-8 pt-6 sm:pt-8">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight mb-4 sm:mb-6">
                            {{ $berita->title }}
                        </h1>
                        
                        <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-sm text-gray-600 mb-6 sm:mb-8 pb-6 sm:pb-8 border-b border-gray-200">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $berita->published_at->format('d F Y') }}</span>
                            </div>
                            <span class="text-gray-300">•</span>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $berita->published_at->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>

                    {{-- Featured Image --}}
                    <div class="px-4 sm:px-6 lg:px-8 mb-6 sm:mb-8">
                        <div class="rounded-lg overflow-hidden bg-gray-100">
                            <img src="{{ asset('storage/' . $berita->image) }}" 
                                 alt="{{ $berita->title }}" 
                                 class="w-full h-auto object-cover">
                        </div>
                    </div>

                    {{-- Article Content --}}
                    <div class="px-4 sm:px-6 lg:px-8 pb-8 sm:pb-12">
                        <div class="prose prose-base max-w-none text-gray-700 leading-relaxed
                            [&_p]:mb-4 [&_p]:leading-relaxed
                            [&_h2]:text-xl [&_h2]:font-bold [&_h2]:text-gray-900 [&_h2]:mt-8 [&_h2]:mb-4
                            [&_h3]:text-lg [&_h3]:font-bold [&_h3]:text-gray-900 [&_h3]:mt-6 [&_h3]:mb-3
                            [&_ul]:list-disc [&_ul]:pl-6 [&_ul]:space-y-2 [&_ul]:mb-4
                            [&_ol]:list-decimal [&_ol]:pl-6 [&_ol]:space-y-2 [&_ol]:mb-4
                            [&_li]:text-gray-700
                            [&_blockquote]:border-l-4 [&_blockquote]:border-emerald-500 [&_blockquote]:pl-4 [&_blockquote]:italic [&_blockquote]:text-gray-600 [&_blockquote]:my-6
                            [&_a]:text-emerald-600 [&_a]:underline
                            [&_strong]:text-gray-900 [&_strong]:font-semibold
                            [&_em]:italic
                            [&_table]:border-collapse [&_table]:w-full [&_table]:mb-4 [&_td]:border [&_td]:border-gray-300 [&_td]:p-2 [&_th]:border [&_th]:border-gray-300 [&_th]:p-2 [&_th]:bg-gray-50">
                            {!! $berita->content !!}
                        </div>
                    </div>
                </article>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-4">
                {{-- Latest News --}}
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 sticky top-24">
                    <div class="mb-6 pb-4 border-b-2 border-green-600">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">Berita Terbaru</h3>
                    </div>
                    
                    <div class="space-y-5">
                        @php
                            // Get latest news excluding current news
                            $latestNews = \App\Models\Berita::where('id', '!=', $berita->id)
                                ->where('published_at', '<=', now())
                                ->orderBy('published_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        
                        @forelse($latestNews as $news)
                        <div class="group">
                            <a href="{{ route('berita.show', $news->id) }}" class="block">
                                <div class="flex gap-3 sm:gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-md overflow-hidden bg-gray-100">
                                            <img src="{{ asset('storage/' . $news->image) }}" 
                                                 alt="{{ $news->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm sm:text-base font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200 line-clamp-3 mb-2">
                                            {{ $news->title }}
                                        </h4>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>{{ $news->published_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        @if(!$loop->last)
                        <div class="border-b border-gray-100"></div>
                        @endif
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            <p class="text-sm">Belum ada berita terbaru</p>
                        </div>
                        @endforelse
                    </div>
                    
                    @if($latestNews->count() > 0)
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <a href="{{ route('berita.index') }}" 
                           class="group inline-flex items-center justify-center w-full text-center text-green-600 hover:text-blue-700 text-sm font-semibold transition-colors py-2 px-4 border border-green-600 rounded-md hover:bg-blue-50">
                            <span>Lihat Semua Berita</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection