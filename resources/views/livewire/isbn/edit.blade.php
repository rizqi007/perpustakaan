<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('isbn.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Perbaiki Pengajuan ISBN</h2>
        </div>

        {{-- Revision Alert --}}
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-300 dark:border-red-700 rounded-xl p-5 mb-6">
            <div class="flex gap-3">
                <span class="text-red-500 text-xl">⚠️</span>
                <div>
                    <h4 class="font-semibold text-red-800 dark:text-red-300 mb-1">Pengajuan Ini Perlu Diperbaiki</h4>
                    <p class="text-sm text-red-700 dark:text-red-400">
                        <span class="font-semibold">Catatan dari Admin:</span>
                        {{ $submission->revision_notes ?? 'Silakan periksa dan perbaiki data pengajuan Anda.' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form wire:submit.prevent="save" class="space-y-8">

                    {{-- SECTION 1: INSTANSI --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-1">Informasi Instansi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-5 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                            <div>
                                <x-input-label for="instansi_type" :value="__('Tipe Instansi')" />
                                <select wire:model.live="instansi_type" id="instansi_type"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="madrasah">Madrasah</option>
                                    <option value="kemenag">Kemenag Kabupaten/Kota</option>
                                    <option value="kanwil">Kantor Wilayah (Kanwil)</option>
                                </select>
                                <x-input-error :messages="$errors->get('instansi_type')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="instansi_name" :value="$instansiNameLabel" />
                                <x-text-input wire:model="instansi_name" id="instansi_name" class="block mt-1 w-full" type="text" required />
                                <x-input-error :messages="$errors->get('instansi_name')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: DATA BUKU --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-1">Data Buku</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="title" :value="__('Judul Buku')" />
                                <x-text-input wire:model="title" id="title" class="block mt-1 w-full" type="text" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="author" :value="__('Penulis')" />
                                <x-text-input wire:model="author" id="author" class="block mt-1 w-full" type="text" required />
                                <x-input-error :messages="$errors->get('author')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="publisher" :value="__('Penerbit')" />
                                <x-text-input wire:model="publisher" id="publisher" class="block mt-1 w-full" type="text" required />
                                <x-input-error :messages="$errors->get('publisher')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="publication_year" :value="__('Tahun Terbit')" />
                                <x-text-input wire:model="publication_year" id="publication_year" class="block mt-1 w-full" type="number" min="1900" max="{{ date('Y') + 2 }}" required />
                                <x-input-error :messages="$errors->get('publication_year')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="pages" :value="__('Jumlah Halaman')" />
                                <x-text-input wire:model="pages" id="pages" class="block mt-1 w-full" type="number" min="1" />
                                <x-input-error :messages="$errors->get('pages')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="language" :value="__('Bahasa')" />
                                <x-text-input wire:model="language" id="language" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('language')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 3: FILE & DESKRIPSI --}}
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="file" :value="__('Ganti File Naskah (opsional, PDF/ZIP/DOC, Maks 10MB)')" />
                            <p class="text-xs text-gray-500 mb-1">Biarkan kosong jika file naskah tidak perlu diganti.</p>
                            <input wire:model="file" id="file" type="file" accept=".pdf,.zip,.rar,.doc,.docx"
                                class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 p-2">
                            <div wire:loading wire:target="file" class="text-sm text-indigo-500 mt-2">Mengunggah file...</div>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi / Catatan Tambahan')" />
                            <textarea wire:model="description" id="description" rows="4"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('isbn.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 underline text-sm">
                            Batal
                        </a>
                        <x-primary-button wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">Kirim Perbaikan</span>
                            <span wire:loading wire:target="save">Mengirim...</span>
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
