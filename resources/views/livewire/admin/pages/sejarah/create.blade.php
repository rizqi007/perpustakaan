<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tambah Sejarah</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-6">
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label for="year" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Tahun</label>
                    <input type="number" wire:model="year" id="year" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    @error('year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Judul</label>
                    <input type="text" wire:model="title" id="title" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Deskripsi</label>
                    <textarea wire:model="description" id="description" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Gambar (Opsional)</label>
                    <input type="file" wire:model="image" id="image" class="w-full text-gray-500 dark:text-gray-400">
                    <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-1">Uploading...</div>
                    @if ($image)
                        <div class="mt-2">
                            <img src="{{ $image->temporaryUrl() }}" class="h-48 w-auto object-cover rounded">
                        </div>
                    @endif
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Aktif</span>
                    </label>
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('admin.pages.sejarah.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white mr-4">Batal</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
