<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
    {{-- Card Header --}}
    <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-6 md:px-8 py-5">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-white">Tambah Permohonan ISBN</h2>
                <p class="text-sm text-indigo-100">Lengkapi data buku Anda dengan benar</p>
            </div>
        </div>
    </div>

    {{-- Form Body --}}
    <form wire:submit.prevent="submit" class="p-6 md:p-8 space-y-8">
        
        {{-- Section 1: Informasi Pemohon --}}
        <div class="bg-gray-50 dark:bg-gray-800/40 p-6 rounded-2xl border border-gray-150 dark:border-gray-800" x-data="{ open: true }">
            <button type="button" @click="open = !open" class="flex items-center justify-between w-full text-left focus:outline-none">
                <h3 class="text-sm font-extrabold text-gray-800 dark:text-white uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informasi Pemohon
                </h3>
                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="open" x-collapse class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-gray-450 dark:text-gray-400 uppercase tracking-wider mb-2">Email Pemohon <span class="text-red-500">*</span></label>
                    <input type="email" wire:model="data.Email" placeholder="Email pemohon"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('data.Email') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <!-- Nama Pemohon -->
                <div>
                    <label class="block text-xs font-bold text-gray-450 dark:text-gray-400 uppercase tracking-wider mb-2">Nama Lengkap Pemohon <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="data.Nama Pemohon" placeholder="Nama pemohon"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('data.Nama Pemohon') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <!-- Nomor Whatsapp -->
                <div>
                    <label class="block text-xs font-bold text-gray-450 dark:text-gray-400 uppercase tracking-wider mb-2">Nomor Whatsapp <span class="text-red-500">*</span></label>
                    <input type="number" wire:model="data.Nomor Whatsapp" placeholder="Contoh: 0812345678"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('data.Nomor Whatsapp') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <!-- Unit Kerja / Satuan Kerja Pemohon -->
                <div>
                    <label class="block text-xs font-bold text-gray-450 dark:text-gray-400 uppercase tracking-wider mb-2">Unit Kerja / Satuan Kerja Pemohon <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="data.Unit Kerja / Satuan Kerja Pemohon " placeholder="Unit kerja"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('data.Unit Kerja / Satuan Kerja Pemohon ') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <!-- Terbitan Pemerintah -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-450 dark:text-gray-400 uppercase tracking-wider mb-2">Jenis Terbitan Pemerintah <span class="text-red-500">*</span></label>
                    <select wire:model="data.Terbitan Pemerintah" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="Non Penelitian">Non Penelitian</option>
                        <option value="Penelitian">Penelitian</option>
                    </select>
                    @error('data.Terbitan Pemerintah') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Section 2: General Info --}}
        <div>
            <h3 class="text-base font-extrabold text-gray-800 dark:text-white border-b border-gray-150 dark:border-gray-800 pb-3 mb-6">General Info</h3>
            
            <div class="space-y-6">
                <!-- Jenis Permohonan ISBN -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4">
                        <span class="block text-sm font-bold text-gray-700 dark:text-gray-300">Jenis Permohonan ISBN <span class="text-red-500">*</span></span>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ selected: @entangle('data.Kategori') }">
                            <!-- Lepas -->
                            <button type="button" @click="selected = 'Lepas'"
                                class="p-5 rounded-2xl border-2 transition-all duration-200 text-left focus:outline-none flex flex-col justify-between group relative overflow-hidden"
                                :class="selected === 'Lepas' ? 'border-indigo-600 bg-indigo-50/10' : 'border-gray-200 dark:border-gray-750 bg-white dark:bg-gray-800 hover:border-indigo-300'">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors shrink-0" :class="selected === 'Lepas' ? 'border-indigo-600' : 'border-gray-300'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-indigo-600" x-show="selected === 'Lepas'"></div>
                                    </div>
                                    <span class="font-extrabold text-sm text-gray-850 dark:text-white">Lepas</span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 leading-relaxed">Penerbit akan mendapatkan 1 nomor ISBN untuk setiap judul yang diminta.</p>
                            </button>
                            
                            <!-- Jilid -->
                            <button type="button" @click="selected = 'Berjilid'"
                                class="p-5 rounded-2xl border-2 transition-all duration-200 text-left focus:outline-none flex flex-col justify-between group relative overflow-hidden"
                                :class="selected === 'Berjilid' ? 'border-indigo-600 bg-indigo-50/10' : 'border-gray-200 dark:border-gray-750 bg-white dark:bg-gray-800 hover:border-indigo-300'">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors shrink-0" :class="selected === 'Berjilid' ? 'border-indigo-600' : 'border-gray-300'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-indigo-600" x-show="selected === 'Berjilid'"></div>
                                    </div>
                                    <span class="font-extrabold text-sm text-gray-850 dark:text-white">Jilid</span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 leading-relaxed">Untuk permohonan jilid baru, penerbit akan menerima minimal 2 ISBN: yaitu 1 ISBN jilid lengkap, serta 1 ISBN yang spesifik untuk jilidnya.</p>
                            </button>
                        </div>
                        @error('data.Kategori') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Judul Buku -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Judul Buku <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <textarea wire:model="data.Judul" rows="3" placeholder="Isi judul buku"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm resize-none"></textarea>
                        @error('data.Judul') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kepengarangan -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                            Kepengarangan <span class="text-red-500">*</span>
                            <span class="block text-xs font-normal text-gray-400 dark:text-gray-500 mt-1 leading-normal">Diisi dengan satu nama orang sesuai dengan perannya. Untuk menambahkan nama beserta peran lainnya, tekan tombol (+)</span>
                        </label>
                    </div>
                    <div class="lg:col-span-8">
                        <div x-data="{
                            role: 'penulis',
                            name: '',
                            authors: [],
                            syncToLivewire() {
                                let str = this.authors.map(a => `${a.name} (${a.role})`).join(', ');
                                $wire.set('data.Kepengarangan ', str);
                            },
                            addAuthor() {
                                if (!this.name.trim()) return;
                                this.authors.push({ role: this.role, name: this.name.trim() });
                                this.name = '';
                                this.syncToLivewire();
                            },
                            removeAuthor(index) {
                                this.authors.splice(index, 1);
                                this.syncToLivewire();
                            },
                            init() {
                                let existing = @js($this->data['Kepengarangan '] ?? '');
                                if (existing) {
                                    let parts = existing.split(', ');
                                    parts.forEach(p => {
                                        let match = p.match(/(.+)\s\((.+)\)/);
                                        if (match) {
                                            this.authors.push({ name: match[1].trim(), role: match[2].trim() });
                                        } else if (p.trim()) {
                                            this.authors.push({ name: p.trim(), role: 'penulis' });
                                        }
                                    });
                                }
                            }
                        }" class="space-y-3">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <!-- Role Selector -->
                                <select x-model="role" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition min-w-[120px] shrink-0">
                                    <option value="penulis">penulis</option>
                                    <option value="editor">editor</option>
                                    <option value="penerjemah">penerjemah</option>
                                    <option value="ilustrator">ilustrator</option>
                                </select>
                                
                                <!-- Name Input -->
                                <input type="text" x-model="name" placeholder="Contoh: John Doe, Alice Gunawan, Fajar Gunawan" @keydown.enter.prevent="addAuthor()"
                                    class="flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                
                                <!-- Plus Button -->
                                <button type="button" @click="addAuthor()" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-extrabold shadow-md transition-all shrink-0">
                                    +
                                </button>
                            </div>
                            
                            <!-- Badges -->
                            <div class="flex flex-wrap gap-2 mt-2">
                                <template x-for="(author, index) in authors" :key="index">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300">
                                        <span x-text="`${author.name} (${author.role})`"></span>
                                        <button type="button" @click="removeAuthor(index)" class="text-gray-400 hover:text-red-500 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </span>
                                </template>
                            </div>
                        </div>
                        @error('data.Kepengarangan ') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Media Terbitan ISBN -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Media Terbitan ISBN <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="flex flex-wrap gap-3" x-data="{ selected: @entangle('data.Media') }">
                            @foreach(['Buku' => 'Cetak', 'Pdf' => 'Digital (PDF)', 'Epub' => 'Digital (EPUB)', 'Audio Book' => 'Audio Book', 'Audio Visual' => 'Audio Visual'] as $val => $lbl)
                                <button type="button" @click="selected = '{{ $val }}'"
                                    class="px-5 py-3 rounded-xl border-2 transition-all duration-200 text-xs font-extrabold focus:outline-none flex items-center gap-2"
                                    :class="selected === '{{ $val }}' ? 'border-indigo-600 bg-indigo-50/10 text-indigo-700' : 'border-gray-200 dark:border-gray-750 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:border-indigo-300'">
                                    <div class="w-3.5 h-3.5 rounded-full border flex items-center justify-center shrink-0" :class="selected === '{{ $val }}' ? 'border-indigo-600' : 'border-gray-350'">
                                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-600" x-show="selected === '{{ $val }}'"></div>
                                    </div>
                                    <span>{{ $lbl }}</span>
                                </button>
                            @endforeach
                        </div>
                        @error('data.Media') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kelompok Pembaca -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Kelompok Pembaca <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="flex flex-wrap gap-3" x-data="{ selected: @entangle('data.Kelompok Pembaca') }">
                            @foreach(['Anak' => 'Anak', 'Dewasa' => 'Dewasa', 'Semua Umur' => 'Semua Umur (SU)'] as $val => $lbl)
                                <button type="button" @click="selected = '{{ $val }}'"
                                    class="px-5 py-3 rounded-xl border-2 transition-all duration-200 text-xs font-extrabold focus:outline-none flex items-center gap-2"
                                    :class="selected === '{{ $val }}' ? 'border-indigo-600 bg-indigo-50/10 text-indigo-700' : 'border-gray-200 dark:border-gray-750 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:border-indigo-300'">
                                    <div class="w-3.5 h-3.5 rounded-full border flex items-center justify-center shrink-0" :class="selected === '{{ $val }}' ? 'border-indigo-600' : 'border-gray-355'">
                                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-600" x-show="selected === '{{ $val }}'"></div>
                                    </div>
                                    <span>{{ $lbl }}</span>
                                </button>
                            @endforeach
                        </div>
                        @error('data.Kelompok Pembaca') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Jenis Pustaka -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Jenis Pustaka <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="flex flex-wrap gap-3" x-data="{ selected: @entangle('data.Jenis Pustaka') }">
                            @foreach(['Fiksi' => 'Fiksi', 'Non Fiksi' => 'Non Fiksi'] as $val => $lbl)
                                <button type="button" @click="selected = '{{ $val }}'"
                                    class="px-5 py-3 rounded-xl border-2 transition-all duration-200 text-xs font-extrabold focus:outline-none flex items-center gap-2"
                                    :class="selected === '{{ $val }}' ? 'border-indigo-600 bg-indigo-50/10 text-indigo-700' : 'border-gray-200 dark:border-gray-750 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:border-indigo-300'">
                                    <div class="w-3.5 h-3.5 rounded-full border flex items-center justify-center shrink-0" :class="selected === '{{ $val }}' ? 'border-indigo-600' : 'border-gray-355'">
                                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-600" x-show="selected === '{{ $val }}'"></div>
                                    </div>
                                    <span>{{ $lbl }}</span>
                                </button>
                            @endforeach
                        </div>
                        @error('data.Jenis Pustaka') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kategori Jenis Pustaka -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Kategori Jenis Pustaka <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="flex flex-wrap gap-3" x-data="{ selected: @entangle('data.Kategori Jenis') }">
                            @foreach(['Terjemahan' => 'Terjemahan', 'Non Terjemahan' => 'Non Terjemahan'] as $val => $lbl)
                                <button type="button" @click="selected = '{{ $val }}'"
                                    class="px-5 py-3 rounded-xl border-2 transition-all duration-200 text-xs font-extrabold focus:outline-none flex items-center gap-2"
                                    :class="selected === '{{ $val }}' ? 'border-indigo-600 bg-indigo-50/10 text-indigo-700' : 'border-gray-200 dark:border-gray-750 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:border-indigo-300'">
                                    <div class="w-3.5 h-3.5 rounded-full border flex items-center justify-center shrink-0" :class="selected === '{{ $val }}' ? 'border-indigo-600' : 'border-gray-355'">
                                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-600" x-show="selected === '{{ $val }}'"></div>
                                    </div>
                                    <span>{{ $lbl }}</span>
                                </button>
                            @endforeach
                        </div>
                        @error('data.Kategori Jenis') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- KDT Request -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Apakah Anda memerlukan Katalog Dalam Terbitan (KDT)?</label>
                    </div>
                    <div class="lg:col-span-8">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition cursor-pointer">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Ya, prioritaskan pengajuan KDT kami.</span>
                        </label>
                    </div>
                </div>

                <!-- Perkiraan Bulan/Tahun Terbit -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Perkiraan Bulan dan Tahun Terbit <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="flex gap-4">
                            <!-- Month Select -->
                            <select class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition flex-1">
                                <option value="">--Pilih Bulan Terbit--</option>
                                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $m)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endforeach
                            </select>
                            
                            <!-- Year Select -->
                            <select wire:model="data.Tahun Terbit" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition w-1/3">
                                @for($y = date('Y'); $y <= date('Y') + 3; $y++)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        @error('data.Tahun Terbit') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Provinsi & Kota Tempat Terbit Buku -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Provinsi Tempat Terbit Buku <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <select class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="DKI Jakarta">DKI Jakarta</option>
                            <option value="Jawa Barat">Jawa Barat</option>
                            <option value="Jawa Tengah">Jawa Tengah</option>
                            <option value="Jawa Timur">Jawa Timur</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Kota/Kabupaten Tempat Terbit <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <select class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="Kota Jakarta Pusat">Kota Jakarta Pusat</option>
                            <option value="Kota Bandung">Kota Bandung</option>
                            <option value="Kota Semarang">Kota Semarang</option>
                            <option value="Kota Surabaya">Kota Surabaya</option>
                        </select>
                    </div>
                </div>

                <!-- Distributor -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Distributor</label>
                    </div>
                    <div class="lg:col-span-8">
                        <input type="text" placeholder="Distributor buku"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                </div>

                <!-- Deskripsi / Abstrak buku -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 font-semibold">Deskripsi / Abstrak buku <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <textarea wire:model="data.Sinopsis Menggambarkan secara ringkas isi terbitan. Minimal 100 kata." rows="4" placeholder="Isi deskripsi / abstrak buku minimal 200 karakter"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm resize-none"></textarea>
                        @error('data.Sinopsis Menggambarkan secara ringkas isi terbitan. Minimal 100 kata.') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Jumlah Halaman & Tinggi Buku -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Dimensi & Ketebalan <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Jumlah Halaman -->
                            <div>
                                <label class="block text-xs font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Jumlah Halaman <span class="text-red-500">*</span></label>
                                <div class="flex items-center gap-3">
                                    <input type="text" wire:model="data.Jumlah Halaman Contoh: viii, 93" placeholder="Contoh: viii, 93"
                                        class="min-w-0 flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    <span class="text-sm font-semibold text-gray-500 shrink-0">halaman</span>
                                </div>
                                @error('data.Jumlah Halaman Contoh: viii, 93') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Tinggi Buku -->
                            <div>
                                <label class="block text-xs font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Tinggi Buku <span class="text-red-500">*</span></label>
                                <div class="flex items-center gap-3">
                                    <input type="text" wire:model="data.Tinggi Buku Contoh: 22" placeholder="Contoh: 22"
                                        class="min-w-0 flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    <span class="text-sm font-semibold text-gray-500 shrink-0">cm</span>
                                </div>
                                @error('data.Tinggi Buku Contoh: 22') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edisi Buku & Seri Buku -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Edisi dan Seri</label>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Edisi Buku -->
                            <div>
                                <label class="block text-xs font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Edisi</label>
                                <input type="text" wire:model="data.Edisi " placeholder="Contoh: Edisi Revisi"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                @error('data.Edisi ') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Seri Buku -->
                            <div>
                                <label class="block text-xs font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Seri Buku <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="data.Seri (Apablila Buku Berseri)" placeholder="Contoh: Seri 1"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                @error('data.Seri (Apablila Buku Berseri)') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ilustrasi -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Apakah terdapat ilustrasi dalam terbitan Anda?</label>
                    </div>
                    <div class="lg:col-span-8">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition cursor-pointer">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Ya, ada ilustrasi.</span>
                        </label>
                    </div>
                </div>

                <!-- Dummy Buku -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Dummy Buku yang akan terbit <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="relative">
                            <input type="file" wire:model="data.File full dummy (format pdf, max 10 MB)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="p-6 border-2 border-dashed border-indigo-200 dark:border-gray-750 bg-indigo-50/5 hover:bg-indigo-50/10 rounded-2xl flex items-center gap-4 transition duration-200">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-gray-700 flex items-center justify-center text-indigo-600 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-extrabold text-gray-800 dark:text-white">Masukan file dummy buku</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Accepted Files: .pdf, .epub, .mp3, .mp4, .wav | Max: 20MB</p>
                                    @if($this->data['File full dummy (format pdf, max 10 MB)'] ?? null)
                                        <p class="text-xs text-green-600 dark:text-green-400 font-bold mt-2">✓ File siap diunggah: {{ is_object($this->data['File full dummy (format pdf, max 10 MB)']) ? $this->data['File full dummy (format pdf, max 10 MB)']->getClientOriginalName() : 'File Terunggah' }}</p>
                                    @elseif(!empty($existingFilePaths['File full dummy (format pdf, max 10 MB)']))
                                        <p class="text-xs text-indigo-600 dark:text-indigo-400 font-bold mt-2">✓ File terunggah saat ini: {{ basename($existingFilePaths['File full dummy (format pdf, max 10 MB)']) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('data.File full dummy (format pdf, max 10 MB)') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- File Attachment -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">File Attachment <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="relative">
                            <input type="file" wire:model="data.File" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="p-6 border-2 border-dashed border-indigo-200 dark:border-gray-750 bg-indigo-50/5 hover:bg-indigo-50/10 rounded-2xl flex items-center gap-4 transition duration-200">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-gray-700 flex items-center justify-center text-indigo-600 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-extrabold text-gray-800 dark:text-white">Masukan attachment</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Berkas Lampiran terdiri atas Surat Permohonan ISBN, Surat Keaslian Karya, Halaman Judul, Halaman Balik Halaman Judul, Halaman Kata Pengantar, dan Halaman Daftar Isi. | Accepted Files: .pdf | Max Size: 5MB</p>
                                    @if($this->data['File'] ?? null)
                                        <p class="text-xs text-green-600 dark:text-green-400 font-bold mt-2">✓ File siap diunggah: {{ is_object($this->data['File']) ? $this->data['File']->getClientOriginalName() : 'File Terunggah' }}</p>
                                    @elseif(!empty($existingFilePaths['File']))
                                        <p class="text-xs text-indigo-600 dark:text-indigo-400 font-bold mt-2">✓ File terunggah saat ini: {{ basename($existingFilePaths['File']) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('data.File') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Cover Buku -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Cover Buku <span class="text-red-500">*</span></label>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="relative">
                            <input type="file" wire:model="data.Cover Buku (format jpg/jpeg/png)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="p-6 border-2 border-dashed border-indigo-200 dark:border-gray-750 bg-indigo-50/5 hover:bg-indigo-50/10 rounded-2xl flex items-center gap-4 transition duration-200">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-gray-700 flex items-center justify-center text-indigo-600 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-extrabold text-gray-800 dark:text-white">Masukan file cover buku</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Accepted Files: .jpg, .png, .jpeg | Max Size: 5MB</p>
                                    @if($this->data['Cover Buku (format jpg/jpeg/png)'] ?? null)
                                        <p class="text-xs text-green-600 dark:text-green-400 font-bold mt-2">✓ File siap diunggah: {{ is_object($this->data['Cover Buku (format jpg/jpeg/png)']) ? $this->data['Cover Buku (format jpg/jpeg/png)']->getClientOriginalName() : 'File Terunggah' }}</p>
                                    @elseif(!empty($existingFilePaths['Cover Buku (format jpg/jpeg/png)']))
                                        <p class="text-xs text-indigo-600 dark:text-indigo-400 font-bold mt-2">✓ File terunggah saat ini: {{ basename($existingFilePaths['Cover Buku (format jpg/jpeg/png)']) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('data.Cover Buku (format jpg/jpeg/png)') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- URL Publikasi -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start py-4">
                    <div class="lg:col-span-4 mt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">URL / LINK publikasi buku</label>
                    </div>
                    <div class="lg:col-span-8">
                        <input type="text" placeholder="contoh: http://"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-150 dark:border-gray-800">
            <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all flex items-center gap-2">
                <span>Submit</span>
                <svg wire:loading.delay wire:target="submit" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </button>
        </div>
    </form>
</div>
