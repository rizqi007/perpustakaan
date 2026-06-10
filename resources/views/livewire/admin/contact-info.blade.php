<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Informasi Kontak</h1>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-6">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Contact Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Detail Kontak</h3>
                        <div>
                            <label for="address" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Alamat</label>
                            <textarea wire:model="address" id="address" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Telepon / WhatsApp</label>
                            <input type="text" wire:model="phone" id="phone" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Email</label>
                            <input type="email" wire:model="email" id="email" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                             <label for="map_embed_url" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">URL Embed Google Maps</label>
                            <input type="text" wire:model="map_embed_url" id="map_embed_url" placeholder="https://www.google.com/maps/embed?..." class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            <p class="text-xs text-gray-500 mt-1">Salin URL dari tag iframe src Google Maps.</p>
                            @error('map_embed_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Opening Hours -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Jam Operasional</h3>
                        <div>
                            <label for="monday_thursday" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Senin - Kamis</label>
                            <input type="text" wire:model="monday_thursday" id="monday_thursday" placeholder="08.00 - 16.00 WIB" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label for="friday" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Jumat</label>
                            <input type="text" wire:model="friday" id="friday" placeholder="08.00 - 16.30 WIB" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label for="saturday" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Sabtu</label>
                            <input type="text" wire:model="saturday" id="saturday" placeholder="Tutup / 08.00 - 12.00" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                         <div>
                            <label for="sunday" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Minggu</label>
                            <input type="text" wire:model="sunday" id="sunday" placeholder="Tutup" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        
                         <div class="pt-6">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">Tampilkan di Website</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end border-t border-gray-200 dark:border-gray-700 pt-4">
                     <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="ml-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
