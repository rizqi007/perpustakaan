<div class="pt-24 pb-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
            @if($profil)
                @if($profil->image)
                    <div class="relative h-64 md:h-80 w-full overflow-hidden">
                        <img src="{{ asset('storage/' . $profil->image) }}" alt="{{ $profil->nama_balai }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8">
                            <h1 class="text-3xl md:text-4xl font-bold text-white shadow-sm">{{ $profil->nama_balai }}</h1>
                        </div>
                    </div>
                @else
                    <div class="p-8 border-b border-gray-100 dark:border-gray-700 bg-emerald-600">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $profil->nama_balai }}</h1>
                    </div>
                @endif

                <div class="p-8 md:p-12">
                    <div class="prose prose-lg prose-slate dark:prose-invert max-w-none 
                        prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-white
                        prose-p:text-gray-700 dark:prose-p:text-gray-300
                        prose-a:text-gray-700 dark:prose-a:text-gray-300 prose-a:font-semibold prose-a:no-underline hover:prose-a:underline
                        prose-img:rounded-xl prose-img:shadow-lg
                        prose-strong:text-gray-900 dark:prose-strong:text-white
                        prose-ul:list-disc prose-ul:pl-5
                        prose-ol:list-decimal prose-ol:pl-5
                        prose-li:marker:text-emerald-500
                        prose-blockquote:border-l-4 prose-blockquote:border-emerald-500 prose-blockquote:pl-4 prose-blockquote:italic prose-blockquote:text-gray-600 dark:prose-blockquote:text-gray-400
                        prose-table:border-collapse prose-table:w-full prose-th:text-left prose-th:p-2 prose-td:p-2 prose-tr:border-b prose-tr:border-gray-200 dark:prose-tr:border-gray-700">
                        {!! $profil->description !!}
                    </div>

                    @if($profil->author)
                        <div class="mt-12 pt-6 border-t border-gray-100 dark:border-gray-700 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            <span>Ditulis oleh: <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $profil->author }}</span></span>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
