<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Layanan</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-6">
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Nama Layanan</label>
                    <input type="text" wire:model="name" id="name" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="url" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">URL Redirect</label>
                    <input type="url" wire:model="url" id="url" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    @error('url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="newImage" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Icon / Gambar</label>
                    <input type="file" wire:model="newImage" id="newImage" class="w-full text-gray-500 dark:text-gray-400">
                    <div wire:loading wire:target="newImage" class="text-sm text-gray-500 mt-1">Uploading...</div>
                    
                    @if ($newImage)
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-1">Preview Baru:</p>
                            <img src="{{ $newImage->temporaryUrl() }}" class="h-24 w-auto object-contain rounded border p-2">
                        </div>
                    @elseif ($oldImage)
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-1">Icon Saat Ini:</p>
                            <img src="{{ asset('storage/' . $oldImage) }}" class="h-24 w-auto object-contain rounded border p-2">
                        </div>
                    @endif
                    @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('admin.layanan.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white mr-4">Batal</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
