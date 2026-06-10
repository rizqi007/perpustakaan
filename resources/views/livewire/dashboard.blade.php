<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200">Dashboard</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Selamat datang, {{ Auth::user()->name }}</p>
            </div>
            @if(count($submissions) > 0)
                <a href="{{ route('isbn.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-sm transition-all shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Ajukan ISBN Baru
                </a>
            @endif
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-300 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ===== STATS GRID ===== --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Pengajuan</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sedang Diproses</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['in_progress'] }}</p>
                </div>
                <div class="p-3 bg-teal-50 dark:bg-teal-950/30 text-teal-600 dark:text-teal-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Perlu Diperbaiki</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['perlu_perbaiki'] }}</p>
                </div>
                <div class="p-3 bg-red-50 dark:bg-red-950/30 text-red-600 dark:text-red-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Selesai</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['selesai'] }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        {{-- ===== SUBMISSIONS LIST ===== --}}
        <div class="space-y-6">
            @forelse($submissions as $submission)
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">


                    <div class="p-6">
                        {{-- Book Info --}}
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $submission->title }}</h3>
                                @if($submission->unit_kerja && $submission->unit_kerja !== '-')
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $submission->unit_kerja }}</p>
                                @endif
                                @if($submission->isbn_number)
                                    <div class="mt-1 flex flex-wrap gap-2">
                                        <div class="inline-flex items-center gap-1 text-xs font-mono text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2 py-0.5 rounded-full">
                                            ISBN: {{ $submission->isbn_number }}
                                        </div>
                                        @if($submission->workflow_status === 'penyerahan_buku')
                                            @if($submission->buku_cetak_diserahkan && $submission->buku_digital_diserahkan)
                                                <div class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2.5 py-0.5 rounded-full border border-green-100 dark:border-green-900/50">
                                                    KCKR Lengkap
                                                </div>
                                            @elseif($submission->buku_cetak_diserahkan && !$submission->buku_digital_diserahkan)
                                                <div class="inline-flex items-center gap-1 text-xs font-semibold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/30 px-2.5 py-0.5 rounded-full border border-amber-100 dark:border-amber-900/50">
                                                    Belum Serahkan Buku Digital
                                                </div>
                                            @elseif(!$submission->buku_cetak_diserahkan && $submission->buku_digital_diserahkan)
                                                <div class="inline-flex items-center gap-1 text-xs font-semibold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/30 px-2.5 py-0.5 rounded-full border border-amber-100 dark:border-amber-900/50">
                                                    Belum Serahkan Buku Cetak
                                                </div>
                                            @else
                                                <div class="inline-flex items-center gap-1 text-xs font-semibold text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/30 px-2.5 py-0.5 rounded-full border border-red-100 dark:border-red-900/50">
                                                    KCKR Belum Diserahkan
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="text-xs text-gray-400 dark:text-gray-500 shrink-0 text-right">
                                <div>Diajukan {{ $submission->created_at->translatedFormat('d F Y') }}</div>
                                @if($submission->workflow_updated_at)
                                    <div>Update: {{ $submission->workflow_updated_at->translatedFormat('d F Y') }}</div>
                                @endif
                            </div>
                        </div>

                        {{-- ===== PROGRESS TRACKER ===== --}}
                        @php
                            $currentStatus = $submission->workflow_status;
                            $isRevision    = $currentStatus === 'perlu_diperbaiki';
                            $stepKeys = collect($trackerSteps)->pluck('key')->toArray();
                            $currentIdx = array_search($currentStatus, $stepKeys);
                            if ($isRevision) $currentIdx = array_search('verifikasi_kemenag', $stepKeys);
                        @endphp

                        @if($isRevision)
                            {{-- Mode Perbaikan: Tampilkan catatan admin saja --}}
                            @if($submission->revision_notes)
                                <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 bg-red-100 dark:bg-red-900/50 rounded-lg flex items-center justify-center mt-0.5">
                                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-red-800 dark:text-red-300 uppercase tracking-wider mb-1">Catatan Perbaikan dari Admin</p>
                                            <p class="text-sm text-red-700 dark:text-red-400 leading-relaxed">{{ $submission->revision_notes }}</p>
                                        </div>
                                        <a href="{{ route('isbn.edit', $submission) }}"
                                            class="shrink-0 inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white font-semibold text-xs px-4 py-2 rounded-lg transition-colors shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Perbaiki
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="inline-flex items-center gap-1.5 text-xs bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 rounded-full px-3 py-1.5 font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        Dikembalikan untuk diperbaiki
                                    </span>
                                </div>
                            @endif
                        @elseif($currentStatus === 'selesai')
                            {{-- Mode Selesai: Tampilkan ucapan selesai dan sembunyikan progress tracker --}}
                            <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-5 text-center shadow-sm">
                                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-950/30 rounded-full flex items-center justify-center mx-auto mb-3 text-emerald-600 dark:text-emerald-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"/></svg>
                                </div>
                                <h4 class="text-base font-bold text-emerald-800 dark:text-emerald-300">🎉 Pengajuan ISBN Selesai!</h4>
                                <p class="text-sm text-emerald-700 dark:text-emerald-400 mt-1 leading-relaxed">Selamat! Pengajuan ISBN Anda untuk buku ini telah selesai diproses dan berhasil diterbitkan oleh Perpustakaan Nasional. Terima kasih atas partisipasi Anda.</p>
                            </div>
                        @else
                            {{-- Mode Normal: Tampilkan progress tracker --}}
                            <div class="relative">
                                {{-- Connector line --}}
                                <div class="absolute top-5 left-5 right-5 h-0.5 bg-gray-200 dark:bg-gray-700 hidden md:block" style="z-index:0"></div>

                                <div class="grid grid-cols-7 gap-1 relative z-10">
                                    @foreach($trackerSteps as $idx => $step)
                                        @php
                                            $isDone    = $idx < $currentIdx;
                                            $isCurrent = $idx === $currentIdx;
                                            $isPending = $idx > $currentIdx;
                                        @endphp
                                        <div class="flex flex-col items-center text-center">
                                            {{-- Circle --}}
                                            <div @class([
                                                'w-10 h-10 rounded-full flex items-center justify-center text-base font-bold transition-all border-2',
                                                'bg-emerald-500 border-emerald-500 text-white shadow-md' => $isDone,
                                                'bg-yellow-500 border-yellow-500 text-white shadow-lg ring-4 ring-yellow-200 dark:ring-yellow-900' => $isCurrent,
                                                'bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-400' => $isPending,
                                            ])>
                                                @if($isDone)
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                @else
                                                    @switch($step['key'])
                                                        @case('data_diterima')
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"/></svg>
                                                            @break
                                                        @case('verifikasi_kemenag')
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                                            @break
                                                        @case('proses_pengajuan')
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                                            @break
                                                        @case('verifikasi_perpusnas')
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                            @break
                                                        @case('isbn_terbit')
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2zM9 16h6M9 12h6M9 8h6"/></svg>
                                                            @break
                                                        @case('penyerahan_buku')
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                            @break
                                                        @case('selesai')
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"/></svg>
                                                            @break
                                                        @default
                                                            {{ $step['icon'] }}
                                                    @endswitch
                                                @endif
                                            </div>
                                            {{-- Label --}}
                                            <div @class([
                                                'mt-2 text-xs leading-tight',
                                                'text-emerald-600 dark:text-emerald-400 font-medium' => $isDone,
                                                'text-yellow-600 dark:text-yellow-400 font-bold' => $isCurrent,
                                                'text-gray-400 dark:text-gray-500' => $isPending,
                                            ])>
                                                {{ $step['label'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($submission->workflow_status === 'penyerahan_buku')
                            <div class="mt-6 p-4 rounded-xl border {{ (!$submission->buku_cetak_diserahkan || !$submission->buku_digital_diserahkan) ? 'bg-amber-50 dark:bg-amber-950/20 border-amber-200 dark:border-amber-800/50' : 'bg-emerald-50 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-800/50' }}">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center mt-0.5 {{ (!$submission->buku_cetak_diserahkan || !$submission->buku_digital_diserahkan) ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400' : 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400' }}">
                                        @if(!$submission->buku_cetak_diserahkan || !$submission->buku_digital_diserahkan)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"/></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold uppercase tracking-wider mb-1 {{ (!$submission->buku_cetak_diserahkan || !$submission->buku_digital_diserahkan) ? 'text-amber-850 dark:text-amber-300' : 'text-emerald-850 dark:text-emerald-300' }}">
                                            Status Penyerahan Buku KCKR
                                        </p>
                                        <div class="text-sm space-y-1.5 {{ (!$submission->buku_cetak_diserahkan || !$submission->buku_digital_diserahkan) ? 'text-amber-700 dark:text-amber-400' : 'text-emerald-700 dark:text-emerald-400' }}">
                                            @if(!$submission->buku_cetak_diserahkan || !$submission->buku_digital_diserahkan)
                                                <p class="font-medium">
                                                    Anda masih belum menyerahkan format buku wajib berikut ke Perpustakaan:
                                                </p>
                                            @else
                                                <p class="font-medium">
                                                    Terima kasih, Anda telah menyerahkan semua format buku wajib. Admin sedang memverifikasi untuk menyelesaikan pengajuan Anda.
                                                </p>
                                            @endif
                                            <div class="flex flex-wrap gap-4 mt-2 pt-1">
                                                <div class="flex items-center gap-2 text-xs">
                                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full {{ $submission->buku_cetak_diserahkan ? 'bg-emerald-100 dark:bg-emerald-900/50' : 'bg-red-50 dark:bg-red-950/30' }}">
                                                        @if($submission->buku_cetak_diserahkan)
                                                            <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                                        @else
                                                            <svg class="w-2.5 h-2.5 text-red-650 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                                        @endif
                                                    </span>
                                                    <span class="font-semibold {{ $submission->buku_cetak_diserahkan ? 'text-emerald-700 dark:text-emerald-300' : 'text-gray-500 dark:text-gray-400' }}">Buku Cetak (Wajib)</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-xs">
                                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full {{ $submission->buku_digital_diserahkan ? 'bg-emerald-100 dark:bg-emerald-900/50' : 'bg-red-50 dark:bg-red-950/30' }}">
                                                        @if($submission->buku_digital_diserahkan)
                                                            <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                                        @else
                                                            <svg class="w-2.5 h-2.5 text-red-650 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                                        @endif
                                                    </span>
                                                    <span class="font-semibold {{ $submission->buku_digital_diserahkan ? 'text-emerald-700 dark:text-emerald-300' : 'text-gray-500 dark:text-gray-400' }}">Buku Digital (Wajib)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <p class="text-gray-500 dark:text-gray-400 mb-4 text-base">Belum ada pengajuan ISBN.</p>
                    <a href="{{ route('isbn.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-emerald-700 transition-all">
                        Ajukan ISBN Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
