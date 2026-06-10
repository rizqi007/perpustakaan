<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Profil Perpustakaan</h1>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-6">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2">
                        <label for="visi" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Visi</label>
                        <textarea wire:model="visi" id="visi" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('visi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="tagline" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Tagline (Moto)</label>
                         <textarea wire:model="tagline" id="tagline" rows="2" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('tagline') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="misi" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Misi (Satu per baris)</label>
                        <textarea wire:model="misi" id="misi" rows="6" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="Misi 1&#10;Misi 2&#10;Misi 3"></textarea>
                        @error('misi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="functions" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Fungsi (Satu per baris)</label>
                        <textarea wire:model="functions" id="functions" rows="6" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('functions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tasks" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Tugas (Satu per baris)</label>
                        <textarea wire:model="tasks" id="tasks" rows="6" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('tasks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="legal_bases" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Dasar Hukum (Satu per baris)</label>
                        <textarea wire:model="legal_bases" id="legal_bases" rows="6" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('legal_bases') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="milestones" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Milestones (Satu per baris)</label>
                        <textarea wire:model="milestones" id="milestones" rows="6" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('milestones') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="collections" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Koleksi Unggulan (Satu per baris)</label>
                        <textarea wire:model="collections" id="collections" rows="6" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('collections') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('admin.pages.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white mr-4">Batal</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
