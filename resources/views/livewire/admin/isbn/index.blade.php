<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Manajemen Pengajuan ISBN</h1>

        {{-- ======= FILTERS ======= --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Cari judul, penulis, pengaju, atau instansi..."
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div class="w-full md:w-64">
                    <select wire:model.live="statusFilter"
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Status Proses</option>
                        <option value="data_diterima">Data Diterima</option>
                        <option value="verifikasi_kemenag">Verifikasi Kemenag</option>
                        <option value="perlu_diperbaiki">Perlu Diperbaiki</option>
                        <option value="proses_pengajuan">Proses Pengajuan</option>
                        <option value="verifikasi_perpusnas">Verifikasi Perpusnas</option>
                        <option value="isbn_terbit">ISBN Terbit</option>
                        <option value="penyerahan_buku">Penyerahan Buku</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- ======= ALERTS ======= --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <span>{{ session('message') }}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- ======= TABLE ======= --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Detail Buku & Instansi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pengaju</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Proses</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($submissions as $submission)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $submission->title }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Penulis: {{ $submission->author }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Penerbit: {{ $submission->publisher }} ({{ $submission->publication_year }})</div>
                                    {{-- Instansi Info --}}
                                    <div class="mt-1 inline-flex items-center gap-1 text-xs text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/40 px-2 py-0.5 rounded-full">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        {{ $submission->instansiLabel }}: {{ $submission->instansi_name ?? '-' }}
                                    </div>
                                    {{-- ISBN Number if published --}}
                                    @if($submission->isbn_number)
                                        <div class="mt-1 text-xs font-mono text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2 py-0.5 rounded-full inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            ISBN: {{ $submission->isbn_number }}
                                        </div>
                                    @endif
                                    {{-- Download button --}}
                                    @if($submission->file_path)
                                        <button wire:click="download({{ $submission->id }})" class="mt-1 text-xs text-indigo-600 hover:text-indigo-900 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            Download Naskah
                                        </button>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $submission->user->name ?? 'User Dihapus' }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $submission->user->email ?? '' }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $submission->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $wfColor = [
                                            'data_diterima'        => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
                                            'verifikasi_kemenag'   => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                                            'perlu_diperbaiki'     => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
                                            'proses_pengajuan'     => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300',
                                            'verifikasi_perpusnas' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300',
                                            'isbn_terbit'          => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                                            'penyerahan_buku'      => 'bg-teal-100 text-teal-800 dark:bg-teal-900/50 dark:text-teal-300',
                                            'selesai'              => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300',
                                        ][$submission->workflow_status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $wfColor }}">
                                        {{ $submission->workflowLabel }}
                                    </span>
                                    @if($submission->workflow_status === 'perlu_diperbaiki' && $submission->revision_notes)
                                        <div class="mt-2 text-xs text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-md p-2 max-w-xs">
                                            <span class="font-semibold block mb-0.5">Catatan revisi:</span>
                                            {{ Str::limit($submission->revision_notes, 80) }}
                                        </div>
                                    @endif
                                    @if($submission->workflow_updated_by)
                                        <div class="text-xs text-gray-400 mt-1">
                                            Diubah: {{ $submission->workflow_updated_at?->format('d M Y H:i') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button wire:click="openWorkflowModal({{ $submission->id }})"
                                        class="inline-flex items-center gap-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-1.5 px-3 rounded-lg text-xs transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Ubah Proses
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Tidak ada data pengajuan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                {{ $submissions->links() }}
            </div>
        </div>

        {{-- ======= WORKFLOW MODAL ======= --}}
        @if($showWorkflowModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4">
                    {{-- Overlay --}}
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="closeModal"></div>

                    {{-- Modal Box --}}
                    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg p-6 z-10">
                        <div class="flex justify-between items-start mb-5">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ubah Status Proses</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Perbarui tahap proses pengajuan ISBN ini.</p>
                            </div>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div class="space-y-4">
                            {{-- Status dropdown --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahap Proses</label>
                                <select wire:model.live="newWorkflowStatus"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Pilih Tahap --</option>
                                    <option value="data_diterima">📥 Data Diterima</option>
                                    <option value="verifikasi_kemenag">🔍 Verifikasi Kemenag</option>
                                    <option value="perlu_diperbaiki">⚠️ Perlu Diperbaiki</option>
                                    <option value="proses_pengajuan">📤 Proses Pengajuan</option>
                                    <option value="verifikasi_perpusnas">📚 Verifikasi Perpusnas</option>
                                    <option value="isbn_terbit">✅ ISBN Terbit</option>
                                    <option value="penyerahan_buku">📖 Penyerahan Buku</option>
                                    <option value="selesai">🎉 Selesai</option>
                                </select>
                                @error('newWorkflowStatus')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Revision Notes (conditional) --}}
                            @if($newWorkflowStatus === 'perlu_diperbaiki')
                                <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 border border-red-200 dark:border-red-800">
                                    <label class="block text-sm font-medium text-red-700 dark:text-red-300 mb-1">
                                        ⚠️ Catatan Perbaikan untuk Pengaju <span class="text-red-500">*</span>
                                    </label>
                                    <textarea wire:model="revisionNotes" rows="4"
                                        placeholder="Jelaskan apa yang perlu diperbaiki oleh pengaju..."
                                        class="w-full rounded-lg border-red-300 dark:border-red-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 text-sm"></textarea>
                                    <p class="text-xs text-red-500 mt-1">Catatan ini akan ditampilkan kepada pengaju di dashboard mereka.</p>
                                    @error('revisionNotes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            @endif

                             {{-- ISBN, Title, and Cover Inputs (conditional) --}}
                             @if(in_array($newWorkflowStatus, ['isbn_terbit', 'penyerahan_buku', 'selesai']))
                                 <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800 space-y-4">
                                     <h4 class="text-sm font-bold text-green-800 dark:text-green-300">📚 Publikasi Katalog Buku (Home)</h4>
                                     
                                     {{-- ISBN --}}
                                     <div>
                                         <label class="block text-xs font-semibold text-green-700 dark:text-green-300 mb-1">
                                             Nomor ISBN <span class="text-red-500">*</span>
                                         </label>
                                         <input wire:model="isbnNumber" type="text"
                                             placeholder="Contoh: 978-602-xxxx-xx-x"
                                             class="w-full rounded-lg border-green-300 dark:border-green-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 font-mono text-sm">
                                         @error('isbnNumber')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                     </div>

                                     {{-- Book Title --}}
                                     <div>
                                         <label class="block text-xs font-semibold text-green-700 dark:text-green-300 mb-1">
                                             Judul Buku & Penulis <span class="text-red-500">*</span>
                                         </label>
                                         <input wire:model="bookTitle" type="text"
                                             class="w-full rounded-lg border-green-300 dark:border-green-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                                         @error('bookTitle')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                     </div>

                                     {{-- Cover Upload --}}
                                     <div>
                                         <label class="block text-xs font-semibold text-green-700 dark:text-green-300 mb-1">
                                             Upload Cover Buku (Opsional)
                                         </label>
                                         <input type="file" wire:model="coverFile"
                                             class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
                                         @error('coverFile')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                         
                                         @if ($coverFile)
                                             <div class="mt-2 text-xs text-gray-500">
                                                 Preview:
                                                 <img src="{{ $coverFile->temporaryUrl() }}" class="mt-1 max-h-32 object-contain rounded border border-green-200">
                                             </div>
                                         @endif
                                     </div>
                                     
                                     <p class="text-[10px] text-green-600 dark:text-green-400">Buku ini akan otomatis diterbitkan di halaman utama (Home) setelah status disimpan.</p>
                                 </div>
                             @endif
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button wire:click="closeModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                                Batal
                            </button>
                            <button wire:click="saveWorkflow" wire:loading.attr="disabled"
                                class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors disabled:opacity-50">
                                <span wire:loading.remove wire:target="saveWorkflow">Simpan Perubahan</span>
                                <span wire:loading wire:target="saveWorkflow">Menyimpan...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
