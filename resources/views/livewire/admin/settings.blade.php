<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Pengaturan Website</h1>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-6">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div>
                            <label for="site_name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Nama Website (Aplikasi)</label>
                            <input type="text" wire:model="site_name" id="site_name" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('site_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="site_description" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Deskripsi Singkat</label>
                            <textarea wire:model="site_description" id="site_description" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                            @error('site_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-4">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="maintenance_mode" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700 dark:text-gray-300 font-bold">Mode Maintenance</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1 ml-6">Jika aktif, hanya admin yang dapat mengakses website.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="logo" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Logo Website</label>
                            <input type="file" wire:model="logo" id="logo" class="w-full text-gray-500 dark:text-gray-400">
                             <div wire:loading wire:target="logo" class="text-sm text-gray-500 mt-1">Uploading...</div>
                            
                            @if ($logo)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Preview Baru:</p>
                                    <img src="{{ $logo->temporaryUrl() }}" class="h-16 w-auto object-contain bg-gray-100 p-2 rounded">
                                </div>
                            @elseif ($existingLogo)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $existingLogo) }}" class="h-16 w-auto object-contain bg-gray-100 p-2 rounded">
                                </div>
                            @endif
                            @error('logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="favicon" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Favicon</label>
                            <input type="file" wire:model="favicon" id="favicon" class="w-full text-gray-500 dark:text-gray-400">
                             <div wire:loading wire:target="favicon" class="text-sm text-gray-500 mt-1">Uploading...</div>

                            @if ($favicon)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Preview Baru:</p>
                                    <img src="{{ $favicon->temporaryUrl() }}" class="h-8 w-8 object-contain">
                                </div>
                            @elseif ($existingFavicon)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $existingFavicon) }}" class="h-8 w-8 object-contain">
                                </div>
                            @endif
                            @error('favicon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end border-t border-gray-200 dark:border-gray-700 pt-4">
                     <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
