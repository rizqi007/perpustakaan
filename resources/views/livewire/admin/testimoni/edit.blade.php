<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Testimoni</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-6">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Nama</label>
                            <input type="text" wire:model="name" id="name" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="institution" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Institusi / Jabatan</label>
                            <input type="text" wire:model="institution" id="institution" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('institution') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="quote" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Kutipan / Testimoni</label>
                            <textarea wire:model="quote" id="quote" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                            @error('quote') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="newPhoto" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Foto</label>
                            <input type="file" wire:model="newPhoto" id="newPhoto" class="w-full text-gray-500 dark:text-gray-400">
                            <div wire:loading wire:target="newPhoto" class="text-sm text-gray-500 mt-1">Uploading...</div>
                            
                            @if ($newPhoto)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Preview Baru:</p>
                                    <img src="{{ $newPhoto->temporaryUrl() }}" class="h-24 w-24 object-cover rounded-full">
                                </div>
                            @elseif ($oldPhoto)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Foto Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $oldPhoto) }}" class="h-24 w-24 object-cover rounded-full">
                                </div>
                            @endif
                            @error('newPhoto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="newVideo" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Video Upload (Opsional)</label>
                            <input type="file" wire:model="newVideo" id="newVideo" class="w-full text-gray-500 dark:text-gray-400">
                            <div wire:loading wire:target="newVideo" class="text-sm text-gray-500 mt-1">Uploading...</div>
                             @if ($oldVideo)
                                <div class="mt-2 text-sm text-gray-500">
                                    Video terupload.
                                </div>
                            @endif
                            @error('newVideo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="youtube_url" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Youtube URL (Opsional)</label>
                            <input type="url" wire:model="youtube_url" id="youtube_url" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('youtube_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-4">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('admin.testimoni.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white mr-4">Batal</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
