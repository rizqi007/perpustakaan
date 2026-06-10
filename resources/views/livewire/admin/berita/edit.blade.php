<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Berita</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-6">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-6">
                        <!-- Left Column (Main Content) -->
                        <div>
                            <label for="title" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Judul Berita</label>
                            <input type="text" wire:model="title" id="title" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div wire:ignore>
                            <label for="content" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Konten</label>
                            <div id="editorjs" class="w-full rounded-md border border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-700 dark:text-white min-h-[300px] p-4 text-gray-900 bg-white relative z-0"></div>
                             @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <script>
                            document.addEventListener('livewire:navigated', () => {
                                const initEditor = () => {
                                    if (typeof EditorJS !== 'undefined') {
                                        let initialData = {};
                                        try {
                                            const rawContent = {!! json_encode($content) !!};
                                            initialData = JSON.parse(rawContent);
                                        } catch (e) {
                                            console.log('Content is not JSON or invalid, starting fresh.');
                                        }

                                        // Check if instance exists and destroy it
                                        if (window.editorInstance) {
                                            try {
                                                window.editorInstance.destroy();
                                            } catch (e) { console.warn('Editor cleanup failed', e); }
                                            window.editorInstance = null;
                                        }

                                        const holder = document.getElementById('editorjs');
                                        if (holder) holder.innerHTML = '';

                                        window.editorInstance = new EditorJS({
                                            holder: 'editorjs',
                                            placeholder: 'Ketik konten berita...',
                                            tools: {
                                                header: Header,
                                                list: List
                                            },
                                            data: initialData,
                                            onChange: () => {
                                                window.editorInstance.save().then((outputData) => {
                                                     @this.set('content', JSON.stringify(outputData));
                                                }).catch((error) => {
                                                    console.log('Saving failed: ', error)
                                                });
                                            }
                                        });
                                    } else {
                                        setTimeout(initEditor, 100);
                                    }
                                };
                                initEditor();
                            });
                        </script>
                    </div>

                    <div class="space-y-6">
                        <!-- Right Column (Settings & Image) -->
                        <div>
                            <label for="newImage" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Gambar Sampul</label>
                            <input type="file" wire:model="newImage" id="newImage" class="w-full text-gray-500 dark:text-gray-400">
                            <div wire:loading wire:target="newImage" class="text-sm text-gray-500 mt-1">Uploading...</div>
                            
                            @if ($newImage)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Preview Baru:</p>
                                    <img src="{{ $newImage->temporaryUrl() }}" class="w-full h-auto object-cover rounded">
                                </div>
                            @elseif ($oldImage)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $oldImage) }}" class="w-full h-auto object-cover rounded">
                                </div>
                            @endif
                            @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="published_at" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Tanggal Publikasi</label>
                            <input type="date" wire:model="published_at" id="published_at" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                             @error('published_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" wire:model="is_published" id="is_published" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <label for="is_published" class="ml-2 text-gray-700 dark:text-gray-300 font-bold">Publikasikan</label>
                        </div>

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                             <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.berita.index') }}" class="block text-center mt-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
