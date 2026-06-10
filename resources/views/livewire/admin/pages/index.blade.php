<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Manajemen Halaman Statis</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Profil Perpustakaan -->
            <a href="{{ route('admin.pages.profil') }}" class="block bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Profil Perpustakaan</h2>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Kelola informasi umum, visi, misi, dan struktur organisasi perpustakaan.</p>
                    </div>
                </div>
            </a>

            <!-- Sejarah Perpustakaan -->
            <a href="{{ route('admin.pages.sejarah.index') }}" class="block bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-l-4 border-amber-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Sejarah Perpustakaan</h2>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Kelola linimasa sejarah dan pencapaian perpustakaan.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
