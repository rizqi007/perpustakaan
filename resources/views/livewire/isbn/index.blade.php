<div class="py-12" x-data="{ 
    activeSubmission: null,
    getStepIndex(status) {
        const steps = {
            'data_diterima': 0,
            'verifikasi_kemenag': 1,
            'perlu_diperbaiki': 1,
            'proses_pengajuan': 2,
            'verifikasi_perpusnas': 3,
            'isbn_terbit': 4,
            'penyerahan_buku': 5,
            'selesai': 6
        };
        return steps[status] ?? 0;
    }
}">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Riwayat Pengajuan ISBN
            </h2>
            <!-- <a href="{{ route('isbn.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition-all">
                + Ajukan Baru
            </a> -->
        </div>

        @php
            $hasPendingKckr = \App\Models\FormSubmission::where('user_id', auth()->id())
                ->where('workflow_status', 'penyerahan_buku')
                ->exists();
        @endphp

        @if($hasPendingKckr)
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/50 rounded-2xl flex items-start gap-4 text-red-800 dark:text-red-300 shadow-sm">
                <div class="p-2 bg-red-100 dark:bg-red-900/40 rounded-xl shrink-0">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-extrabold uppercase tracking-wide mb-1">Pemberitahuan Serah Simpan Karya (KCKR)</h4>
                    <p class="text-xs leading-relaxed text-red-700 dark:text-red-400">
                        Anda memiliki pengajuan ISBN yang sudah terbit, tetapi buku fisik/cetak **belum diserahkan** sebagai kepatuhan wajib KCKR (Serah Simpan Karya Cetak & Karya Rekam).
                        Silakan segera serahkan minimal 7 eks buku cetak ke Perpustakaan Kementerian Agama RI agar status pengajuan Anda dapat diselesaikan dan nomor ISBN dapat ditampilkan secara penuh.
                    </p>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-visible shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 mb-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{-- Search & Filter Row --}}
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="flex-1 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            placeholder="Cari judul buku, penulis, atau nomor ISBN..."
                            class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/40 dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:bg-white dark:focus:bg-gray-900 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 text-sm transition-all duration-300 shadow-sm hover:border-gray-300 dark:hover:border-gray-650">
                    </div>
                    <div x-data="{ 
                        open: false,
                        selected: @entangle('statusFilter'),
                        options: [
                            { key: '', label: 'Semua Status Proses', color: 'text-gray-400 dark:text-gray-500' },
                            { key: 'data_diterima', label: 'Data Diterima', color: 'text-blue-500' },
                            { key: 'verifikasi_kemenag', label: 'Verifikasi Kemenag', color: 'text-amber-500' },
                            { key: 'perlu_diperbaiki', label: 'Perlu Diperbaiki', color: 'text-rose-500' },
                            { key: 'menunggu_review', label: 'Sudah Diperbaiki', color: 'text-violet-500' },
                            { key: 'proses_pengajuan', label: 'Proses Pengajuan', color: 'text-indigo-500' },
                            { key: 'verifikasi_perpusnas', label: 'Verifikasi Perpusnas', color: 'text-fuchsia-500' },
                            { key: 'isbn_terbit', label: 'ISBN Terbit', color: 'text-emerald-500' },
                            { key: 'penyerahan_buku', label: 'Penyerahan Buku', color: 'text-teal-500' },
                            { key: 'selesai', label: 'Selesai', color: 'text-green-500' }
                        ]
                    }" class="w-full md:w-72 relative">
                        <!-- Dropdown Button -->
                        <button type="button" @click="open = !open" 
                            class="w-full flex items-center justify-between pl-4 pr-10 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/40 dark:bg-gray-900 text-gray-900 dark:text-white hover:border-gray-300 dark:hover:border-gray-650 transition-all duration-200 focus:outline-none focus:bg-white dark:focus:bg-gray-900 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 text-sm shadow-sm text-left">
                            <span class="flex items-center gap-2.5 truncate">
                                <!-- Status Icon -->
                                <span :class="options.find(o => o.key === (selected || ''))?.color || 'text-gray-400'">
                                    <template x-if="!selected">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/></svg>
                                    </template>
                                    <template x-if="selected === 'data_diterima'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.008 1.24l.885 1.77a2.25 2.25 0 0 0 2.007 1.24h1.98a2.25 2.25 0 0 0 2.007-1.24l.885-1.77a2.25 2.25 0 0 1 2.007-1.24h3.86m-18 0h19.5M9 10.5l3 3m0 0 3-3m-3 3V1.5"/></svg>
                                    </template>
                                    <template x-if="selected === 'verifikasi_kemenag'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                                    </template>
                                    <template x-if="selected === 'perlu_diperbaiki'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></template>
                                    </template>
                                    <template x-if="selected === 'menunggu_review'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                    </template>
                                    <template x-if="selected === 'proses_pengajuan'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                                    </template>
                                    <template x-if="selected === 'verifikasi_perpusnas'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5H4.5V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></svg>
                                    </template>
                                    <template x-if="selected === 'isbn_terbit'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/></svg>
                                    </template>
                                    <template x-if="selected === 'penyerahan_buku'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </template>
                                    <template x-if="selected === 'selesai'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                    </template>
                                </span>
                                <span class="truncate font-semibold text-gray-700 dark:text-gray-200" x-text="options.find(o => o.key === (selected || ''))?.label || 'Semua Status Proses'"></span>
                            </span>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none transition-transform duration-200" :class="open ? 'rotate-180' : ''">
                                <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown List Options -->
                        <div x-show="open" 
                            @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute z-30 mt-1.5 w-full bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-xl shadow-xl max-h-80 overflow-y-auto py-1 custom-scrollbar focus:outline-none"
                            style="display: none;">
                            
                            <template x-for="opt in options" :key="opt.key">
                                <button type="button" @click="selected = opt.key; open = false;"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm transition-colors text-left hover:bg-gray-50 dark:hover:bg-gray-800/60 focus:outline-none"
                                    :class="selected === opt.key ? 'bg-emerald-50/50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 font-semibold' : 'text-gray-700 dark:text-gray-300'">
                                    <!-- Status Icon -->
                                    <span :class="opt.color">
                                        <template x-if="!opt.key">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/></svg>
                                        </template>
                                        <template x-if="opt.key === 'data_diterima'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.008 1.24l.885 1.77a2.25 2.25 0 0 0 2.007 1.24h1.98a2.25 2.25 0 0 0 2.007-1.24l.885-1.77a2.25 2.25 0 0 1 2.007-1.24h3.86m-18 0h19.5M9 10.5l3 3m0 0 3-3m-3 3V1.5"/></svg>
                                        </template>
                                        <template x-if="opt.key === 'verifikasi_kemenag'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                                        </template>
                                        <template x-if="opt.key === 'perlu_diperbaiki'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                        </template>
                                        <template x-if="opt.key === 'menunggu_review'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                        </template>
                                        <template x-if="opt.key === 'proses_pengajuan'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                                        </template>
                                        <template x-if="opt.key === 'verifikasi_perpusnas'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5H4.5V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></svg>
                                        </template>
                                        <template x-if="opt.key === 'isbn_terbit'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/></svg>
                                        </template>
                                        <template x-if="opt.key === 'penyerahan_buku'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </template>
                                        <template x-if="opt.key === 'selesai'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                        </template>
                                    </span>
                                    <span x-text="opt.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                @if($submissions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Data Pengajuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Proses</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($submissions as $submission)
                                    @php
                                        $data = $submission->data ?? [];
                                        $judul = $data['Judul'] ?? $data['judul'] ?? $data['Judul Naskah'] ?? '-';
                                        $penulis = $data['Penulis'] ?? $data['penulis'] ?? '-';
                                        $wfStatus = $submission->workflow_status ?? 'data_diterima';
                                        $wfColor = [
                                            'data_diterima'        => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
                                            'verifikasi_kemenag'   => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                                            'perlu_diperbaiki'     => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
                                            'menunggu_review'      => 'bg-violet-100 text-violet-800 dark:bg-violet-900/50 dark:text-violet-300',
                                            'proses_pengajuan'     => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300',
                                            'verifikasi_perpusnas' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300',
                                            'isbn_terbit'          => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                                            'penyerahan_buku'      => 'bg-teal-100 text-teal-800 dark:bg-teal-900/50 dark:text-teal-300',
                                            'selesai'              => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300',
                                        ][$wfStatus] ?? 'bg-gray-100 text-gray-800';
                                        $wfLabel = [
                                            'data_diterima'        => 'Data Diterima',
                                            'verifikasi_kemenag'   => 'Verifikasi Kemenag',
                                            'perlu_diperbaiki'     => 'Perlu Diperbaiki',
                                            'menunggu_review'      => 'Sudah Diperbaiki',
                                            'proses_pengajuan'     => 'Proses Pengajuan',
                                            'verifikasi_perpusnas' => 'Verifikasi Perpusnas',
                                            'isbn_terbit'          => 'ISBN Terbit',
                                            'penyerahan_buku'      => 'Penyerahan Buku',
                                            'selesai'              => 'Selesai',
                                        ][$wfStatus] ?? ucfirst($wfStatus);

                                        // Resolve files physical existence
                                        $suratPermohonanKey = null;
                                        foreach ($data as $key => $value) {
                                            if (str_contains(strtolower($key), 'surat permohonan') && !empty($value)) {
                                                $suratPermohonanKey = $key;
                                                break;
                                            }
                                        }
                                        $suratPermohonanPath = $suratPermohonanKey ? $data[$suratPermohonanKey] : null;
                                        $suratPermohonanExists = $suratPermohonanPath && file_exists(storage_path('app/public/' . $suratPermohonanPath));

                                        $fileLampiranKey = null;
                                        foreach ($data as $key => $value) {
                                            if (strtolower(trim($key)) === 'file' && !empty($value)) {
                                                $fileLampiranKey = $key;
                                                break;
                                            }
                                        }
                                        $fileLampiranPath = $fileLampiranKey ? $data[$fileLampiranKey] : null;
                                        $fileLampiranExists = $fileLampiranPath && file_exists(storage_path('app/public/' . $fileLampiranPath));

                                        $fileDummyKey = null;
                                        foreach ($data as $key => $value) {
                                            if (str_contains(strtolower($key), 'dummy') && !empty($value)) {
                                                $fileDummyKey = $key;
                                                break;
                                            }
                                        }
                                        $fileDummyPath = $fileDummyKey ? $data[$fileDummyKey] : null;
                                        $fileDummyExists = $fileDummyPath && file_exists(storage_path('app/public/' . $fileDummyPath));

                                        $coverKey = null;
                                        foreach ($data as $key => $value) {
                                            if (str_contains(strtolower($key), 'cover') && !empty($value)) {
                                                $coverKey = $key;
                                                break;
                                            }
                                        }
                                        $coverPath = $coverKey ? $data[$coverKey] : null;
                                        $coverExists = $coverPath && file_exists(storage_path('app/public/' . $coverPath));

                                        $modalData = [
                                            'id' => $submission->id,
                                            'judul' => $judul,
                                            'penulis' => $penulis,
                                            'penerbit' => $submission->publisher,
                                            'tahun_terbit' => $submission->publication_year,
                                            'edisi' => $submission->edisi,
                                            'seri' => $submission->seri,
                                            'jumlah_halaman' => $submission->jumlah_halaman,
                                            'tinggi_buku' => $submission->tinggi_buku,
                                            'kelompok_pembaca' => $submission->kelompok_pembaca,
                                            'jenis_pustaka' => $submission->jenis_pustaka,
                                            'kategori_jenis' => $submission->kategori_jenis,
                                            'media' => $submission->media,
                                            'kategori' => $submission->kategori,
                                            'sinopsis' => $submission->synopsis,
                                            'isbn_number' => $submission->isbn_number,
                                            'workflow_status' => $submission->workflow_status,
                                            'workflow_label' => $wfLabel,
                                            'workflow_color' => $wfColor,
                                            'revision_notes' => $submission->revision_notes,
                                            'surat_permohonan' => $submission->surat_permohonan_url,
                                            'surat_permohonan_exists' => $suratPermohonanExists,
                                            'file_lampiran' => $submission->file_lampiran_url,
                                            'file_lampiran_exists' => $fileLampiranExists,
                                            'file_dummy' => $submission->file_dummy_url,
                                            'file_dummy_exists' => $fileDummyExists,
                                            'cover_url' => $submission->cover_url,
                                            'cover_exists' => $coverExists,
                                            'kdt_text' => $submission->kdt_text,
                                            'kdt_file' => $submission->kdt_file_url,
                                            'kdt_file_exists' => $submission->kdt_file && file_exists(storage_path('app/public/' . $submission->kdt_file)),
                                        ];
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $submission->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <!-- Cover Thumbnail -->
                                                <div class="w-12 h-16 bg-gray-100 dark:bg-gray-750 rounded overflow-hidden flex-shrink-0 flex items-center justify-center border border-gray-200 dark:border-gray-750 shadow-sm">
                                                    @if($submission->cover_url && $coverExists)
                                                        @if(Str::endsWith(strtolower($submission->cover_url), '.pdf'))
                                                            <!-- PDF Icon Cover -->
                                                            <div class="flex flex-col items-center justify-center bg-red-50 dark:bg-red-950/20 w-full h-full">
                                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                                <span class="text-[8px] font-bold text-red-600 dark:text-red-400 mt-0.5">PDF</span>
                                                            </div>
                                                        @else
                                                            <img src="{{ $submission->cover_url }}" class="w-full h-full object-cover">
                                                        @endif
                                                    @else
                                                        <!-- Missing / generic Cover fallback -->
                                                        <div class="flex flex-col items-center justify-center w-full h-full bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                            <span class="text-[7px] font-semibold mt-0.5 uppercase tracking-tighter">No File</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <div>
                                                    <button type="button" @click="activeSubmission = @js($modalData)" class="text-sm font-bold text-left text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors focus:outline-none">
                                                        {{ $judul }}
                                                    </button>
                                                    @if($penulis !== '-')
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">Oleh: {{ $penulis }}</div>
                                                    @endif
                                                     @if($submission->workflow_status !== 'perlu_diperbaiki')
                                                         @if($submission->isbn_number)
                                                             <div class="mt-1 text-xs font-mono text-green-700 dark:text-green-400 font-semibold">ISBN: {{ $submission->isbn_number }}</div>
                                                         @endif
                                                         @if($submission->workflow_status === 'penyerahan_buku')
                                                             <div class="mt-1">
                                                                 <span class="bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-400 text-[10px] px-2 py-0.5 rounded border border-red-100 dark:border-red-900/50 font-bold">KCKR Belum Diserahkan</span>
                                                             </div>
                                                         @endif
                                                     @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($wfStatus)
                                                @case('data_diterima')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50/60 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 border border-blue-150/80 dark:border-blue-900/40">
                                                        <svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.008 1.24l.885 1.77a2.25 2.25 0 0 0 2.007 1.24h1.98a2.25 2.25 0 0 0 2.007-1.24l.885-1.77a2.25 2.25 0 0 1 2.007-1.24h3.86m-18 0h19.5M9 10.5l3 3m0 0 3-3m-3 3V1.5"/>
                                                        </svg>
                                                        <span>Data Diterima</span>
                                                    </span>
                                                    @break
                                                @case('verifikasi_kemenag')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50/60 dark:bg-amber-950/20 text-amber-700 dark:text-amber-300 border border-amber-150/80 dark:border-amber-900/40">
                                                        <span class="flex h-1.5 w-1.5 relative shrink-0">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-amber-500"></span>
                                                        </span>
                                                        <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                                        </svg>
                                                        <span>Verifikasi Kemenag</span>
                                                    </span>
                                                    @break
                                                @case('perlu_diperbaiki')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50/60 dark:bg-rose-950/20 text-rose-700 dark:text-rose-300 border border-rose-150/80 dark:border-rose-900/40">
                                                        <span class="flex h-1.5 w-1.5 relative shrink-0">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-rose-500"></span>
                                                        </span>
                                                        <svg class="w-3.5 h-3.5 text-rose-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                                                        </svg>
                                                        <span>Perlu Diperbaiki</span>
                                                    </span>
                                                    @break
                                                @case('menunggu_review')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-violet-50/60 dark:bg-violet-950/20 text-violet-700 dark:text-violet-300 border border-violet-150/80 dark:border-violet-900/40">
                                                        <span class="flex h-1.5 w-1.5 relative shrink-0">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-violet-500"></span>
                                                        </span>
                                                        <svg class="w-3.5 h-3.5 text-violet-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                                        </svg>
                                                        <span>Sudah Diperbaiki</span>
                                                    </span>
                                                    @break
                                                @case('proses_pengajuan')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50/60 dark:bg-indigo-950/20 text-indigo-700 dark:text-indigo-300 border border-indigo-150/80 dark:border-indigo-900/40">
                                                        <span class="flex h-1.5 w-1.5 relative shrink-0">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-indigo-500"></span>
                                                        </span>
                                                        <svg class="w-3.5 h-3.5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                                                        </svg>
                                                        <span>Proses Pengajuan</span>
                                                    </span>
                                                    @break
                                                @case('verifikasi_perpusnas')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-fuchsia-50/60 dark:bg-fuchsia-950/20 text-fuchsia-700 dark:text-fuchsia-300 border border-fuchsia-150/80 dark:border-fuchsia-900/40">
                                                        <span class="flex h-1.5 w-1.5 relative shrink-0">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-fuchsia-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-fuchsia-500"></span>
                                                        </span>
                                                        <svg class="w-3.5 h-3.5 text-fuchsia-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5H4.5V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/>
                                                        </svg>
                                                        <span>Verifikasi Perpusnas</span>
                                                    </span>
                                                    @break
                                                @case('isbn_terbit')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50/60 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-300 border border-emerald-150/80 dark:border-emerald-900/40">
                                                        <svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/>
                                                        </svg>
                                                        <span>ISBN Terbit</span>
                                                    </span>
                                                    @break
                                                @case('penyerahan_buku')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-teal-50/60 dark:bg-teal-950/20 text-teal-700 dark:text-teal-300 border border-teal-150/80 dark:border-teal-900/40">
                                                        <span class="flex h-1.5 w-1.5 relative shrink-0">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-teal-500"></span>
                                                        </span>
                                                        <svg class="w-3.5 h-3.5 text-teal-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                        </svg>
                                                        <span>Penyerahan Buku</span>
                                                    </span>
                                                    @break
                                                @case('selesai')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50/60 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-300 border border-emerald-150/80 dark:border-emerald-900/40">
                                                        <svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                                        </svg>
                                                        <span>Selesai</span>
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50/60 dark:bg-gray-950/20 text-gray-700 dark:text-gray-300 border border-gray-150/80 dark:border-gray-900/40">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                        <span>{{ $wfLabel }}</span>
                                                    </span>
                                            @endswitch
                                            @if($wfStatus === 'perlu_diperbaiki' && $submission->revision_notes)
                                                <div class="mt-1 text-xs text-red-650 dark:text-red-400 font-medium">
                                                    {{ Str::limit($submission->revision_notes, 60) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold">
                                            <button type="button" @click="activeSubmission = @js($modalData)" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors duration-150 mr-4 focus:outline-none">
                                                Lihat Detail
                                            </button>
                                            @if($wfStatus === 'perlu_diperbaiki')
                                                <a href="{{ route('isbn.edit', $submission->id) }}" class="text-amber-600 dark:text-amber-400 hover:text-amber-900 dark:hover:text-amber-300 transition-colors duration-150">
                                                    Perbaiki
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $submissions->links() }}
                    </div>
                @else
                    <div class="text-center py-10">
                        @if(!empty($search) || !empty($statusFilter))
                            <p class="text-gray-500 dark:text-gray-400 mb-4 font-medium">Tidak ada riwayat pengajuan yang cocok dengan kata kunci atau status pencarian Anda.</p>
                            <button wire:click="$set('search', ''); $set('statusFilter', '');" class="inline-flex items-center px-4 py-2 bg-indigo-50 border border-indigo-200 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-950/20 dark:border-indigo-900/50 dark:text-indigo-400 rounded-xl font-semibold text-xs transition focus:outline-none">
                                Reset Filter & Pencarian
                            </button>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Anda belum memiliki riwayat pengajuan ISBN.</p>
                            <a href="{{ route('isbn.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                Ajukan ISBN Sekarang
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Detail Submission Modal -->
    <div x-show="activeSubmission" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Modal Backdrop -->
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="activeSubmission = null"></div>

        <!-- Modal Dialog -->
        <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden transform transition-all flex flex-col max-h-[90vh]"
             x-show="activeSubmission"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
             
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-850">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Detail Pengajuan ISBN</span>
                </h3>
                <button @click="activeSubmission = null" class="p-1.5 bg-gray-150 dark:bg-gray-800 hover:bg-red-100 dark:hover:bg-red-950 text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 rounded-full transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="p-6 overflow-y-auto flex-1 max-h-[calc(90vh-140px)] custom-scrollbar">
                
                <!-- Stepper Progress Tracker -->
                <div class="mb-8 bg-gray-50 dark:bg-gray-800/40 p-6 rounded-2xl border border-gray-100 dark:border-gray-800">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-6">Status & Alur Proses</h4>
                    
                    <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6 md:gap-0">
                        <!-- Connecting Line (Desktop) -->
                        <div class="hidden md:block absolute top-[18px] left-[6%] right-[6%] h-1 bg-gray-200 dark:bg-gray-700 z-0">
                            <div class="h-full bg-emerald-500 transition-all duration-500" 
                                 :style="`width: ${activeSubmission.workflow_status === 'perlu_diperbaiki' ? '16.66%' : (getStepIndex(activeSubmission.workflow_status) / 6 * 100) + '%'}`">
                            </div>
                        </div>
                        
                        <!-- Step 1: Data Diterima -->
                        <div class="flex md:flex-col items-center gap-3 md:gap-2 relative z-10 md:w-1/7 text-center">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shadow-sm transition-colors duration-300"
                                 :class="getStepIndex(activeSubmission.workflow_status) >= 0 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">Data Diterima</span>
                        </div>

                        <!-- Step 2: Verifikasi Kemenag / Perlu Diperbaiki -->
                        <div class="flex md:flex-col items-center gap-3 md:gap-2 relative z-10 md:w-1/7 text-center">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shadow-sm transition-colors duration-300"
                                 :class="activeSubmission.workflow_status === 'perlu_diperbaiki' ? 'bg-red-500 text-white animate-pulse' : (getStepIndex(activeSubmission.workflow_status) >= 1 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500')">
                                <template x-if="activeSubmission.workflow_status === 'perlu_diperbaiki'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </template>
                                <template x-if="activeSubmission.workflow_status !== 'perlu_diperbaiki'">
                                    <span x-show="getStepIndex(activeSubmission.workflow_status) > 1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                    <span x-show="getStepIndex(activeSubmission.workflow_status) <= 1" x-text="activeSubmission.workflow_status === 'verifikasi_kemenag' ? '⏳' : '2'"></span>
                                </template>
                            </div>
                            <span class="text-xs font-semibold" :class="activeSubmission.workflow_status === 'perlu_diperbaiki' ? 'text-red-600 dark:text-red-400 font-bold' : 'text-gray-700 dark:text-gray-300'">
                                <span x-text="activeSubmission.workflow_status === 'perlu_diperbaiki' ? 'Perlu Diperbaiki' : 'Verifikasi Kemenag'"></span>
                            </span>
                        </div>

                        <!-- Step 3: Proses Pengajuan -->
                        <div class="flex md:flex-col items-center gap-3 md:gap-2 relative z-10 md:w-1/7 text-center">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shadow-sm transition-colors duration-300"
                                 :class="activeSubmission.workflow_status !== 'perlu_diperbaiki' && getStepIndex(activeSubmission.workflow_status) >= 2 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'">
                                <span x-show="getStepIndex(activeSubmission.workflow_status) > 2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span x-show="getStepIndex(activeSubmission.workflow_status) <= 2" x-text="activeSubmission.workflow_status === 'proses_pengajuan' ? '⏳' : '3'"></span>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">Proses Pengajuan</span>
                        </div>

                        <!-- Step 4: Verifikasi Perpusnas -->
                        <div class="flex md:flex-col items-center gap-3 md:gap-2 relative z-10 md:w-1/7 text-center">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shadow-sm transition-colors duration-300"
                                 :class="activeSubmission.workflow_status !== 'perlu_diperbaiki' && getStepIndex(activeSubmission.workflow_status) >= 3 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'">
                                <span x-show="getStepIndex(activeSubmission.workflow_status) > 3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span x-show="getStepIndex(activeSubmission.workflow_status) <= 3" x-text="activeSubmission.workflow_status === 'verifikasi_perpusnas' ? '⏳' : '4'"></span>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">Verifikasi Perpusnas</span>
                        </div>

                        <!-- Step 5: ISBN Terbit -->
                        <div class="flex md:flex-col items-center gap-3 md:gap-2 relative z-10 md:w-1/7 text-center">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shadow-sm transition-colors duration-300"
                                 :class="activeSubmission.workflow_status !== 'perlu_diperbaiki' && getStepIndex(activeSubmission.workflow_status) >= 4 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'">
                                <span x-show="getStepIndex(activeSubmission.workflow_status) > 4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span x-show="getStepIndex(activeSubmission.workflow_status) <= 4" x-text="activeSubmission.workflow_status === 'isbn_terbit' ? '⏳' : '5'"></span>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">ISBN Terbit</span>
                        </div>

                        <!-- Step 6: Penyerahan Buku -->
                        <div class="flex md:flex-col items-center gap-3 md:gap-2 relative z-10 md:w-1/7 text-center">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shadow-sm transition-colors duration-300"
                                 :class="activeSubmission.workflow_status !== 'perlu_diperbaiki' && getStepIndex(activeSubmission.workflow_status) >= 5 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'">
                                <span x-show="getStepIndex(activeSubmission.workflow_status) > 5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span x-show="getStepIndex(activeSubmission.workflow_status) <= 5" x-text="activeSubmission.workflow_status === 'penyerahan_buku' ? '⏳' : '6'"></span>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">Penyerahan Buku</span>
                        </div>

                        <!-- Step 7: Selesai -->
                        <div class="flex md:flex-col items-center gap-3 md:gap-2 relative z-10 md:w-1/7 text-center">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shadow-sm transition-colors duration-300"
                                 :class="activeSubmission.workflow_status !== 'perlu_diperbaiki' && getStepIndex(activeSubmission.workflow_status) >= 6 ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'">
                                <span x-show="getStepIndex(activeSubmission.workflow_status) === 6">✓</span>
                                <span x-show="getStepIndex(activeSubmission.workflow_status) < 6">7</span>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">Selesai</span>
                        </div>
                    </div>

                    <!-- Catatan Perbaikan -->
                    <div x-show="activeSubmission.workflow_status === 'perlu_diperbaiki' && activeSubmission.revision_notes" 
                         class="mt-6 p-4 bg-red-50 dark:bg-red-950/20 border border-red-100 dark:border-red-900/50 rounded-xl flex gap-3 text-red-700 dark:text-red-400 text-sm">
                         <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                         <div>
                             <span class="font-bold">Catatan Perbaikan dari Admin:</span>
                             <p class="mt-1 font-medium" x-text="activeSubmission.revision_notes"></p>
                         </div>
                    </div>
                </div>

                <!-- Detail Columns -->
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Left: Cover Book & Uploaded Files -->
                    <div class="w-full md:w-1/3 flex-shrink-0 flex flex-col items-center">
                        <div class="w-full max-w-[200px] bg-gray-50 dark:bg-gray-800 rounded-2xl overflow-hidden flex items-center justify-center p-6 border border-gray-200 dark:border-gray-800 relative shadow-lg aspect-[3/4]">
                            <!-- Blur background visual effect -->
                            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat blur-[30px] opacity-20 scale-125" :style="`background-image: url('${activeSubmission.cover_url}')`" x-show="activeSubmission.cover_url && activeSubmission.cover_exists && !activeSubmission.cover_url.toLowerCase().endsWith('.pdf')"></div>
                            
                            <!-- Cover file exists and is not PDF -->
                            <template x-if="activeSubmission.cover_url && activeSubmission.cover_exists && !activeSubmission.cover_url.toLowerCase().endsWith('.pdf')">
                                <img :src="activeSubmission.cover_url" class="relative z-10 w-full shadow-2xl rounded rounded-r-xl object-contain h-auto max-h-full">
                            </template>

                            <!-- Cover file exists and IS a PDF -->
                            <template x-if="activeSubmission.cover_url && activeSubmission.cover_exists && activeSubmission.cover_url.toLowerCase().endsWith('.pdf')">
                                <div class="relative z-10 w-full h-full flex flex-col items-center justify-center text-center">
                                    <svg class="w-16 h-16 text-red-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    <span class="text-xs font-bold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/40 px-2.5 py-1 rounded border border-red-150 dark:border-red-900/50">PDF COVER</span>
                                    <a :href="activeSubmission.cover_url" target="_blank" class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                                        Buka PDF Cover
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 00-2 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </div>
                            </template>

                            <!-- Cover file does not exist in local directory -->
                            <template x-if="activeSubmission.cover_url && !activeSubmission.cover_exists">
                                <div class="relative z-10 w-full h-full flex flex-col items-center justify-center text-center text-amber-600 dark:text-amber-500">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <span class="text-[10px] font-bold bg-amber-50 dark:bg-amber-950/20 px-2 py-1 rounded border border-amber-250 dark:border-amber-900/40">File Tidak Ada di Server</span>
                                </div>
                            </template>
                            
                            <!-- Cover URL is not set/empty -->
                            <template x-if="!activeSubmission.cover_url">
                                <div class="relative z-10 w-full h-full flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <span class="text-xs font-semibold">Tidak ada Cover</span>
                                </div>
                            </template>
                        </div>

                        <!-- Documents Download Block -->
                        <div class="w-full mt-6 bg-gray-50 dark:bg-gray-800/40 p-4 rounded-xl border border-gray-150 dark:border-gray-800">
                            <h5 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-3">Dokumen Terunggah</h5>
                            <div class="flex flex-col gap-2">
                                <!-- Surat Permohonan -->
                                <template x-if="activeSubmission.surat_permohonan">
                                    <div>
                                        <!-- If Exists -->
                                        <template x-if="activeSubmission.surat_permohonan_exists">
                                            <a :href="activeSubmission.surat_permohonan" target="_blank" class="flex items-center gap-2 px-3 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-lg text-xs font-bold text-gray-700 dark:text-gray-300 transition-colors">
                                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                <span class="truncate">Surat Permohonan</span>
                                            </a>
                                        </template>
                                        <!-- If Missing -->
                                        <template x-if="!activeSubmission.surat_permohonan_exists">
                                            <div class="flex items-center justify-between gap-2 px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-xs font-semibold text-gray-400 dark:text-gray-500 cursor-not-allowed">
                                                <div class="flex items-center gap-2 truncate">
                                                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                    <span class="truncate">Surat Permohonan</span>
                                                </div>
                                                <span class="text-[9px] font-bold text-amber-600 dark:text-amber-500 shrink-0">Tidak Ada</span>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <!-- File Halaman/Kata Pengantar dll -->
                                <template x-if="activeSubmission.file_lampiran">
                                    <div>
                                        <!-- If Exists -->
                                        <template x-if="activeSubmission.file_lampiran_exists">
                                            <a :href="activeSubmission.file_lampiran" target="_blank" class="flex items-center gap-2 px-3 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-lg text-xs font-bold text-gray-700 dark:text-gray-300 transition-colors">
                                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                <span class="truncate">File Lampiran Gabungan</span>
                                            </a>
                                        </template>
                                        <!-- If Missing -->
                                        <template x-if="!activeSubmission.file_lampiran_exists">
                                            <div class="flex items-center justify-between gap-2 px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-xs font-semibold text-gray-400 dark:text-gray-500 cursor-not-allowed">
                                                <div class="flex items-center gap-2 truncate">
                                                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                    <span class="truncate">File Lampiran Gabungan</span>
                                                </div>
                                                <span class="text-[9px] font-bold text-amber-600 dark:text-amber-500 shrink-0">Tidak Ada</span>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <!-- File Dummy Buku -->
                                <template x-if="activeSubmission.file_dummy">
                                    <div>
                                        <!-- If Exists -->
                                        <template x-if="activeSubmission.file_dummy_exists">
                                            <a :href="activeSubmission.file_dummy" target="_blank" class="flex items-center gap-2 px-3 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-lg text-xs font-bold text-gray-700 dark:text-gray-300 transition-colors">
                                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                <span class="truncate">Full Draft / Dummy</span>
                                            </a>
                                        </template>
                                        <!-- If Missing -->
                                        <template x-if="!activeSubmission.file_dummy_exists">
                                            <div class="flex items-center justify-between gap-2 px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-xs font-semibold text-gray-400 dark:text-gray-500 cursor-not-allowed">
                                                <div class="flex items-center gap-2 truncate">
                                                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                    <span class="truncate">Full Draft / Dummy</span>
                                                </div>
                                                <span class="text-[9px] font-bold text-amber-600 dark:text-amber-500 shrink-0">Tidak Ada</span>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Book Metadata & Details -->
                    <div class="w-full md:w-2/3 flex flex-col gap-6">
                        <div>
                            <!-- ISBN Display if exists -->
                            <template x-if="activeSubmission.isbn_number && activeSubmission.workflow_status !== 'perlu_diperbaiki'">
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 dark:bg-green-950/40 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 font-mono text-sm font-bold rounded-lg">
                                        <span>ISBN:</span>
                                        <span x-text="activeSubmission.isbn_number"></span>
                                    </div>
                                    <template x-if="activeSubmission.workflow_status === 'penyerahan_buku'">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 text-xs font-bold rounded-lg">
                                            <span>KCKR Belum Diserahkan</span>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <!-- Modal level KCKR Alert -->
                            <template x-if="activeSubmission.isbn_number && activeSubmission.workflow_status === 'penyerahan_buku'">
                                <div class="mb-4 p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/50 rounded-xl flex gap-3 text-red-700 dark:text-red-400 text-xs leading-relaxed">
                                    <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <div>
                                        <span class="font-bold block mb-1">Kewajiban Serah Simpan (KCKR) Belum Dipenuhi:</span>
                                        Nomor ISBN telah diterbitkan, namun Anda wajib menyerahkan **minimal 7 eksemplar buku cetak** ke Perpustakaan Kementerian Agama RI untuk menyelesaikan seluruh proses pengajuan.
                                    </div>
                                </div>
                            </template>

                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white leading-tight" x-text="activeSubmission.judul"></h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1" x-show="activeSubmission.penulis && activeSubmission.penulis !== '-'">
                                Oleh: <span class="font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.penulis"></span>
                            </p>
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-800/20 p-5 rounded-2xl border border-gray-100 dark:border-gray-800">
                            <!-- Publisher & Year -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Penerbit</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.penerbit || '-'"></span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Tahun Terbit</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.tahun_terbit || '-'"></span>
                            </div>

                            <!-- Edisi & Seri -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Edisi</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.edisi || '-'"></span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Seri Buku</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.seri || '-'"></span>
                            </div>

                            <!-- Pages & Dimensions -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Jumlah Halaman</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.jumlah_halaman || '-'"></span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Tinggi Buku</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.tinggi_buku || '-'"></span>
                            </div>

                            <!-- Type and Audience -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Kelompok Pembaca</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.kelompok_pembaca || '-'"></span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Jenis Pustaka</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.jenis_pustaka || '-'"></span>
                            </div>

                            <!-- Media and Category -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Media Terbitan</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.media || '-'"></span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Kategori</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200" x-text="activeSubmission.kategori || '-'"></span>
                            </div>
                        </div>

                        <!-- Synopsis -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-2 border-b border-gray-100 dark:border-gray-800 pb-2">Sinopsis</h4>
                            <div class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line custom-scrollbar max-h-40 overflow-y-auto pr-2" x-html="activeSubmission.sinopsis || '<em class=\'text-gray-400\'>Tidak ada sinopsis tersedia.</em>'"></div>
                        </div>

                        <!-- Katalog Dalam Terbitan (KDT) Block -->
                        <div x-show="activeSubmission.workflow_status === 'isbn_terbit' || activeSubmission.workflow_status === 'penyerahan_buku' || activeSubmission.workflow_status === 'selesai'" 
                             class="border-t border-gray-100 dark:border-gray-800 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Katalog Dalam Terbitan (KDT)</h4>
                                
                                <div class="flex items-center gap-2">
                                    <!-- Print KDT Card button if text exists -->
                                    <template x-if="activeSubmission.kdt_text">
                                        <button type="button" @click="printKdtCard(activeSubmission.kdt_text)"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:hover:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 rounded-lg text-xs font-bold transition-all border border-emerald-100 dark:border-emerald-900/50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Cetak KDT
                                        </button>
                                    </template>

                                    <!-- Download KDT File button if file exists -->
                                    <template x-if="activeSubmission.kdt_file && activeSubmission.kdt_file_exists">
                                        <a :href="activeSubmission.kdt_file" target="_blank" 
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/40 dark:hover:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 rounded-lg text-xs font-bold transition-all border border-indigo-100 dark:border-indigo-900/50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Unduh File KDT
                                        </a>
                                    </template>
                                </div>
                            </div>
                            
                            <!-- If KDT text is provided -->
                            <template x-if="activeSubmission.kdt_text">
                                <div class="bg-gray-50 dark:bg-gray-800/40 border border-gray-200 dark:border-gray-700 rounded-xl p-5 font-mono text-xs text-gray-800 dark:text-gray-300 whitespace-pre-line leading-relaxed relative overflow-hidden shadow-inner max-w-full">
                                    <div class="absolute top-0 right-0 px-2 py-0.5 bg-indigo-600 text-white text-[9px] font-black uppercase tracking-widest rounded-bl-lg">KDT CARD</div>
                                    <span x-text="activeSubmission.kdt_text"></span>
                                </div>
                            </template>
                            
                            <!-- If neither text nor file is ready yet -->
                            <template x-if="!activeSubmission.kdt_text && (!activeSubmission.kdt_file || !activeSubmission.kdt_file_exists)">
                                <div class="p-4 bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/50 rounded-xl flex items-center gap-3 text-amber-800 dark:text-amber-400 text-xs font-medium">
                                    <svg class="w-4 h-4 shrink-0 text-amber-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <span>Katalog Dalam Terbitan (KDT) belum diinput oleh admin. Silakan periksa beberapa saat lagi.</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-850">
                <template x-if="activeSubmission.workflow_status === 'perlu_diperbaiki'">
                    <a :href="`/isbn/${activeSubmission.id}/edit`" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-lg shadow-amber-200 dark:shadow-none transition-all duration-150">
                        Perbaiki Pengajuan
                    </a>
                </template>
                <button @click="activeSubmission = null" class="px-5 py-2.5 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors focus:outline-none">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function printKdtCard(text) {
            let win = window.open('', '_blank', 'width=800,height=600');
            let doc = win.document;
            doc.write('<!DOCTYPE html>');
            doc.write('<html><head><title>Cetak KDT<\/title>');
            doc.write('<style>body { font-family: monospace; padding: 40px; display: flex; justify-content: center; align-items: center; min-height: 80vh; background: #fff; } .kdt-card { border: 2px solid #000; padding: 30px; white-space: pre-wrap; font-size: 14px; width: 600px; line-height: 1.6; }<\/style>');
            doc.write('<\/head><body onload="window.print(); window.close();">');
            doc.write('<div class="kdt-card">');
            doc.write(text);
            doc.write('<\/div><\/body><\/html>');
            doc.close();
        }
    </script>
</div>
