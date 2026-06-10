@push('meta')
    @php
        $description = \Illuminate\Support\Str::limit(strip_tags($resensi->cleaned_content), 150);
    @endphp
    <meta property="og:title" content="{{ $resensi->title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ asset('storage/' . $resensi->cover_image) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    <meta name="twitter:card" content="summary_large_image">
@endpush

<div class="py-12 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Sidebar (Book Info & Cover) -->
            <div class="lg:col-span-4 space-y-8 lg:order-last">
                <!-- Cover Image -->
                <div class="relative rounded-2xl overflow-hidden shadow-2xl group">
                    <img src="{{ asset('storage/' . $resensi->cover_image) }}" 
                         alt="{{ $resensi->title }}" 
                         class="w-full h-auto object-cover transform transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>

                 <!-- Reviewer Info -->
                 <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-3">Diresensi Oleh</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold">
                            {{ substr($resensi->reviewer_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-gray-900 font-bold">{{ $resensi->reviewer_name }}</p>
                            <p class="text-xs text-gray-500">{{ $resensi->created_at->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                 </div>


            </div>

            <!-- Main Content Area -->
            <article class="lg:col-span-8">
                <header class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full uppercase tracking-wider">Resensi Buku</span>
                        <span class="text-sm text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $resensi->published_at ? $resensi->published_at->translatedFormat('d F Y') : $resensi->created_at->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        {{ $resensi->title }}
                    </h1>
                </header>

                <!-- Premium Book Metadata Card -->
                <div class="mb-8 p-6 bg-gradient-to-br from-emerald-50/20 via-slate-50 to-teal-50/10 rounded-2xl border border-emerald-100/50 shadow-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <!-- Judul Buku -->
                        <div class="space-y-1.5">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-600 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                Judul Buku
                            </span>
                            <h4 class="font-bold text-gray-900 leading-tight text-sm md:text-base">{{ $resensi->book_details['judul'] ?? $resensi->book_title }}</h4>
                        </div>
                        
                        <!-- Pengarang -->
                        <div class="space-y-1.5 sm:border-l sm:border-emerald-100/50 sm:pl-6">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-600 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Pengarang
                            </span>
                            <p class="font-semibold text-gray-800 text-sm md:text-base">{{ $resensi->book_details['penulis'] ?? $resensi->author }}</p>
                        </div>
                        
                        <!-- Penerbit -->
                        <div class="space-y-1.5 md:border-l md:border-emerald-100/50 md:pl-6">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-600 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Penerbit
                            </span>
                            <p class="font-semibold text-gray-800 text-sm md:text-base">{{ $resensi->book_details['penerbit'] ?? '-' }}</p>
                        </div>
                        
                        <!-- Tebal -->
                        <div class="space-y-1.5 md:border-l md:border-emerald-100/50 md:pl-6">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-600 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Tebal Buku
                            </span>
                            <p class="font-semibold text-gray-800 text-sm md:text-base">{{ $resensi->book_details['tebal'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>

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
                    {!! $resensi->cleaned_content !!}
                </div>

                <!-- Back Button (Mobile) -->
                <div class="lg:hidden mt-8 pt-8 border-t border-gray-100">
                    <a href="{{ route('resensi.index') }}" class="flex items-center justify-center w-full px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-emerald-600 hover:text-white transition">
                        Kembali ke Daftar Resensi
                    </a>
                </div>
            </article>

        </div>
    </div>
</div>
