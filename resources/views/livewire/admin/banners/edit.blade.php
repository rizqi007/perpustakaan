<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Banner</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-6">
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Judul</label>
                    <input type="text" wire:model="title" id="title" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Deskripsi</label>
                    <textarea wire:model="description" id="description" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="newImage" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Gambar</label>
                    <input type="file" wire:model="newImage" id="newImage" class="w-full text-gray-500 dark:text-gray-400">
                    <div wire:loading wire:target="newImage" class="text-sm text-gray-500 mt-1">Uploading...</div>
                    
                    @if ($newImage)
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-1">Preview Baru:</p>
                            <img src="{{ $newImage->temporaryUrl() }}" class="h-48 w-auto object-cover rounded">
                        </div>
                    @elseif ($oldImage)
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-1">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $oldImage) }}" class="h-48 w-auto object-cover rounded">
                        </div>
                    @endif
                    @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Aktif</span>
                    </label>
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('admin.banners.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white mr-4">Batal</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
