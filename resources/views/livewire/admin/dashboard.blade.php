<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Admin</h1>
            {{-- Export Button --}}
            <button onclick="exportDashboard()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl transition-colors shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export Statistik (PDF)
            </button>
        </div>

        {{-- ===== STATS GRID ===== --}}
        <div id="stats-section" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 border-l-4 border-indigo-500">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Total Pengguna</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['users'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 border-l-4 border-yellow-500">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">ISBN Proses</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['isbn_pending'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 border-l-4 border-emerald-500">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">ISBN Selesai</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['isbn_selesai'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 border-l-4 border-green-500">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Total Berita</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['berita'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 border-l-4 border-pink-500">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Total Layanan</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['layanan'] }}</p>
            </div>
        </div>

        {{-- ===== VISITOR SUMMARY CARDS ===== --}}
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">📊 Statistik Pengunjung</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow p-5 text-white">
                    <p class="text-xs font-medium text-blue-100 uppercase tracking-wide mb-1">Pengunjung Hari Ini</p>
                    <p class="text-4xl font-bold">{{ $visitorToday }}</p>
                    <p class="text-xs text-blue-200 mt-1">IP unik {{ now()->format('d M Y') }}</p>
                </div>
                <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl shadow p-5 text-white">
                    <p class="text-xs font-medium text-violet-100 uppercase tracking-wide mb-1">7 Hari Terakhir</p>
                    <p class="text-4xl font-bold">{{ $visitorWeek }}</p>
                    <p class="text-xs text-violet-200 mt-1">IP unik per hari</p>
                </div>
                <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl shadow p-5 text-white">
                    <p class="text-xs font-medium text-teal-100 uppercase tracking-wide mb-1">30 Hari Terakhir</p>
                    <p class="text-4xl font-bold">{{ $visitorMonth }}</p>
                    <p class="text-xs text-teal-200 mt-1">IP unik per hari</p>
                </div>
            </div>

            {{-- ===== CHARTS ROW ===== --}}
            <div id="charts-section" class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                {{-- LINE CHART: Website visitors --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4">Kunjungan Website (30 Hari Terakhir)</h3>
                    <canvas id="visitorLineChart" height="280"></canvas>
                </div>

                {{-- BAR CHART: Per layanan --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4">Pengunjung Per Layanan</h3>
                    @if($serviceStats->isNotEmpty())
                        <canvas id="serviceBarChart" height="280"></canvas>
                    @else
                        <div class="flex items-center justify-center h-40 text-gray-400 text-sm">
                            Belum ada data layanan
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== RECENT ISBN SUBMISSIONS ===== --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Pengajuan ISBN Terbaru</h3>
                <a href="{{ route('admin.isbn.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Judul / Penulis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Pengaju</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Instansi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status Proses</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentSubmissions as $submission)
                            @php
                                $wfColor = [
                                    'data_diterima'        => 'bg-blue-100 text-blue-800',
                                    'verifikasi_kemenag'   => 'bg-yellow-100 text-yellow-800',
                                    'perlu_diperbaiki'     => 'bg-red-100 text-red-800',
                                    'proses_pengajuan'     => 'bg-indigo-100 text-indigo-800',
                                    'verifikasi_perpusnas' => 'bg-purple-100 text-purple-800',
                                    'isbn_terbit'          => 'bg-green-100 text-green-800',
                                    'penyerahan_buku'      => 'bg-teal-100 text-teal-800',
                                    'selesai'              => 'bg-emerald-100 text-emerald-800',
                                ][$submission->workflow_status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $submission->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $submission->author }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $submission->user->name ?? 'User Dihapus' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $submission->instansiLabel }}<br>{{ $submission->instansi_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $wfColor }}">
                                        {{ $submission->workflowLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('admin.isbn.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Review</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>

        {{-- ===== SLIMS CONNECTION SETTINGS & TESTER ===== --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden mb-8 border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-50 dark:bg-emerald-950/30 rounded-xl">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Integrasi & Koneksi Database SLiMS</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Atur kredensial dan uji koneksi ke database SLiMS untuk sinkronisasi otomatis.</p>
                    </div>
                </div>
                
                {{-- Enabled Toggle --}}
                <div class="flex items-center gap-3 bg-gray-50 dark:bg-gray-700/50 px-4 py-2 rounded-xl border border-gray-100 dark:border-gray-700">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Status Integrasi:</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="slimsEnabled" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-250 dark:bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                        <span class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300">
                            {{ $slimsEnabled ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </label>
                </div>
            </div>

            <div class="p-6">
                {{-- Flash Messages --}}
                @if (session()->has('settings_success'))
                    <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/20 border-l-4 border-emerald-500 rounded-r-xl flex items-start text-emerald-800 dark:text-emerald-300 text-sm">
                        <svg class="w-5 h-5 mr-3 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('settings_success') }}</span>
                    </div>
                @endif
                
                @if (session()->has('settings_error'))
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-950/20 border-l-4 border-red-500 rounded-r-xl flex items-start text-red-800 dark:text-red-300 text-sm">
                        <svg class="w-5 h-5 mr-3 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('settings_error') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Left side: Configuration Fields --}}
                    <div class="space-y-5">
                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Kredensial Database</h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="sm:col-span-2">
                                <label for="slimsHost" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Host Database SLiMS</label>
                                <input type="text" id="slimsHost" wire:model.defer="slimsHost" placeholder="e.g. 127.0.0.1"
                                    class="w-full px-4 py-2 text-sm bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:text-white transition-all">
                                @error('slimsHost') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="slimsPort" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Port</label>
                                <input type="text" id="slimsPort" wire:model.defer="slimsPort" placeholder="e.g. 3306"
                                    class="w-full px-4 py-2 text-sm bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:text-white transition-all">
                                @error('slimsPort') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="slimsDatabase" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Nama Database SLiMS</label>
                            <input type="text" id="slimsDatabase" wire:model.defer="slimsDatabase" placeholder="e.g. slims9"
                                class="w-full px-4 py-2 text-sm bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:text-white transition-all">
                            @error('slimsDatabase') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="slimsUsername" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Username Database</label>
                                <input type="text" id="slimsUsername" wire:model.defer="slimsUsername" placeholder="e.g. root"
                                    class="w-full px-4 py-2 text-sm bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:text-white transition-all">
                                @error('slimsUsername') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div x-data="{ showPassword: false }">
                                <label for="slimsPassword" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Password Database</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" id="slimsPassword" wire:model.defer="slimsPassword" placeholder="••••••••"
                                        class="w-full px-4 py-2 pr-10 text-sm bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:text-white transition-all">
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!showPassword">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="showPassword" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                @error('slimsPassword') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="button" wire:click="testConnection" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-150 hover:bg-gray-200 dark:bg-gray-705 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold text-sm rounded-xl transition-all shadow-sm">
                                <svg wire:loading.remove wire:target="testConnection" class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <svg wire:loading wire:target="testConnection" class="w-4 h-4 animate-spin text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span>Cek Koneksi</span>
                            </button>

                            <button type="button" wire:click="saveSettings" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl transition-all shadow shadow-emerald-500/10">
                                <svg wire:loading.remove wire:target="saveSettings" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                <svg wire:loading wire:target="saveSettings" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span>Simpan Konfigurasi</span>
                            </button>
                        </div>
                    </div>

                    {{-- Right side: Connection Status Info --}}
                    <div class="flex flex-col justify-between h-full bg-gray-50 dark:bg-gray-900/30 p-5 rounded-2xl border border-gray-100 dark:border-gray-800">
                        <div>
                            <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-3">Status Koneksi</h4>
                            
                            {{-- Test Results State --}}
                            @if ($testStatus === 'testing')
                                <div class="p-4 bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800/50 rounded-xl flex items-center gap-3">
                                    <svg class="w-6 h-6 animate-spin text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-blue-800 dark:text-blue-300">Menghubungkan...</p>
                                        <p class="text-xs text-blue-600 dark:text-blue-400">Sedang mencoba melakukan handshake ke database SLiMS.</p>
                                    </div>
                                </div>
                            @elseif ($testStatus === 'success')
                                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl flex items-start gap-3">
                                    <div class="p-1 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg shrink-0">
                                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">Koneksi Berhasil</p>
                                        <p class="text-xs text-emerald-600 dark:text-emerald-400">{{ $testMessage }}</p>
                                    </div>
                                </div>
                            @elseif ($testStatus === 'failed')
                                <div class="p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/50 rounded-xl flex items-start gap-3">
                                    <div class="p-1 bg-red-100 dark:bg-red-900/50 rounded-lg shrink-0">
                                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-red-800 dark:text-red-300">Koneksi Gagal</p>
                                        <p class="text-xs text-red-600 dark:text-red-400 overflow-hidden text-ellipsis">{{ $testMessage }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="p-4 bg-gray-100 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl flex items-start gap-3">
                                    <div class="p-1 bg-gray-200 dark:bg-gray-700 rounded-lg shrink-0">
                                        <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum Ada Pengujian</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Tekan tombol "Cek Koneksi" di samping untuk memverifikasi kredensial database Anda.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 pt-5 border-t border-gray-200/60 dark:border-gray-700/60 text-xs text-gray-500 dark:text-gray-400 space-y-2">
                            <p class="font-semibold text-gray-700 dark:text-gray-300">💡 Petunjuk Singkat:</p>
                            <ul class="list-disc list-inside space-y-1 pl-1">
                                <li>Pastikan port database Anda terbuka (default SLiMS/MySQL adalah <code class="bg-gray-200 dark:bg-gray-800 px-1 py-0.5 rounded">3306</code>).</li>
                                <li>Gunakan host <code class="bg-gray-200 dark:bg-gray-800 px-1 py-0.5 rounded">127.0.0.1</code> atau <code class="bg-gray-200 dark:bg-gray-800 px-1 py-0.5 rounded">localhost</code> jika SLiMS berada di server yang sama.</li>
                                <li>Modifikasi ini akan memperbarui berkas konfigurasi <code class="bg-gray-200 dark:bg-gray-800 px-1 py-0.5 rounded">.env</code> secara langsung.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== Chart.js & Export Scripts ===== --}}
<script src="{{ asset('vendor/js/chart.umd.min.js') }}"></script>
<script src="{{ asset('vendor/js/html2canvas.min.js') }}"></script>
<script src="{{ asset('vendor/js/jspdf.umd.min.js') }}"></script>

<script>
    // ===== Visitor Line Chart =====
    const visitorLabels = @json(json_decode($visitorChartLabels));
    const visitorData   = @json(json_decode($visitorChartData));

    const lineCtx = document.getElementById('visitorLineChart');
    if (lineCtx) {
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: visitorLabels,
                datasets: [{
                    label: 'Pengunjung Unik',
                    data: visitorData,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.12)',
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#6366f1',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { ticks: { maxRotation: 45, font: { size: 10 } } }
                }
            }
        });
    }

    // ===== Service Bar Chart =====
    @php
        $serviceLabels = $serviceStats->pluck('label');
        $serviceTotals = $serviceStats->pluck('total');
    @endphp
    const serviceLabels = @json($serviceLabels);
    const serviceTotals = @json($serviceTotals);

    const barCtx = document.getElementById('serviceBarChart');
    if (barCtx && serviceLabels.length > 0) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: serviceLabels,
                datasets: [{
                    label: 'Pengunjung Layanan',
                    data: serviceTotals,
                    backgroundColor: [
                        'rgba(99,102,241,0.75)',
                        'rgba(20,184,166,0.75)',
                        'rgba(245,158,11,0.75)',
                        'rgba(239,68,68,0.75)',
                        'rgba(168,85,247,0.75)',
                        'rgba(34,197,94,0.75)',
                    ],
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { ticks: { font: { size: 10 } } }
                }
            }
        });
    }

    // ===== Export Dashboard as PDF =====
    async function exportDashboard() {
        const btn = event.target.closest('button');
        const orig = btn.innerHTML;
        btn.innerHTML = '<svg class="w-4 h-4 animate-spin mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Membuat PDF...';
        btn.disabled = true;

        try {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });

            const now = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
            pdf.setFontSize(16);
            pdf.text('Laporan Statistik Dashboard', 14, 18);
            pdf.setFontSize(10);
            pdf.setTextColor(120);
            pdf.text('Dicetak: ' + now, 14, 26);

            // Capture stats section
            const statsEl = document.getElementById('stats-section');
            const statsCanvas = await html2canvas(statsEl, { scale: 1.5, useCORS: true });
            const statsImg = statsCanvas.toDataURL('image/png');
            pdf.addImage(statsImg, 'PNG', 14, 32, 268, 28);

            // Capture charts section
            const chartsEl = document.getElementById('charts-section');
            const chartsCanvas = await html2canvas(chartsEl, { scale: 1.5, useCORS: true });
            const chartsImg = chartsCanvas.toDataURL('image/png');
            const chartH = chartsCanvas.height * (268 / chartsCanvas.width);
            pdf.addImage(chartsImg, 'PNG', 14, 66, 268, Math.min(chartH, 120));

            pdf.save('statistik-dashboard-' + new Date().toISOString().slice(0, 10) + '.pdf');
        } catch (e) {
            alert('Gagal mengekspor PDF: ' + e.message);
        }

        btn.innerHTML = orig;
        btn.disabled = false;
    }
</script>
