<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Hubungi Kami</h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami melalui formulir di bawah ini atau kunjungi lokasi kami.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Contact Info -->
            <div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 h-full">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Informasi Kontak</h2>
                    
                    <div class="space-y-6">
                        @if($contactInfo)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-emerald-100 dark:bg-emerald-900/50 p-3 rounded-full text-emerald-600 dark:text-emerald-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Alamat</h3>
                                    <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $contactInfo->address }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-emerald-100 dark:bg-emerald-900/50 p-3 rounded-full text-emerald-600 dark:text-emerald-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Telepon</h3>
                                    <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $contactInfo->phone }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-emerald-100 dark:bg-emerald-900/50 p-3 rounded-full text-emerald-600 dark:text-emerald-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Email</h3>
                                    <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $contactInfo->email }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">Informasi kontak belum tersedia.</p>
                        @endif
                    </div>

                    @if($contactInfo && $contactInfo->map_embed_url)
                        <div class="mt-8 rounded-lg overflow-hidden h-64 border border-gray-200 dark:border-gray-700 shadow-inner">
                            <iframe src="{{ $contactInfo->map_embed_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                     @if (session()->has('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Kirim Pesan</h2>
                    
                    <form wire:submit.prevent="submit" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                            <input wire:model="name" type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white sm:text-sm p-3">
                            @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input wire:model="email" type="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white sm:text-sm p-3">
                                @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon (Opsional)</label>
                                <input wire:model="phone" type="text" id="phone" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white sm:text-sm p-3">
                                @error('phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subjek</label>
                            <input wire:model="subject" type="text" id="subject" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white sm:text-sm p-3">
                             @error('subject') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pesan</label>
                            <textarea wire:model="message" id="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white sm:text-sm p-3"></textarea>
                             @error('message') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="captcha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Captcha</label>
                            <div class="flex items-center gap-4 mt-1">
                                <span class="rounded overflow-hidden">{!! captcha_img() !!}</span>
                                <button type="button" class="text-sm text-emerald-600 hover:text-emerald-500" onclick="location.reload()">Refresh</button>
                            </div>
                            <input wire:model="captcha" type="text" id="captcha" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white sm:text-sm p-3" placeholder="Masukkan kode captcha">
                            @error('captcha') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
