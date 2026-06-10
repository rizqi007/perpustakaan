<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-50 relative font-sans">
    
    {{-- Google Font for Card --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        .kartu-font, .kartu-font * {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
    </style>
    {{-- Decorative Background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-100 rounded-full opacity-40 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-teal-100 rounded-full opacity-40 blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 py-12 md:py-20">

        {{-- Header --}}
        <div class="text-center mb-10">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 text-sm font-semibold mb-6 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Beranda
            </a>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">Cetak Kartu Anggota</h1>
            <p class="text-gray-500 max-w-lg mx-auto">Masukkan NIP Anda untuk mencari dan mencetak kartu anggota perpustakaan.</p>
        </div>

        {{-- Search Form --}}
        @if(!$anggota)
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 max-w-xl mx-auto">
            <form wire:submit="cari" class="space-y-5">
                <div>
                    <label for="nip" class="flex text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
                        NIP / ID Anggota
                    </label>
                    <input type="text" id="nip" wire:model="nip"
                        class="w-full px-4 py-3 border border-gray-200 text-gray-800 text-base rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all duration-200"
                        placeholder="Masukkan NIP Anda, contoh: ANG-2026-0001" autofocus>
                    @error('nip') <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p> @enderror
                </div>

                @if($notFound)
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <div>
                        <p class="text-red-800 font-semibold text-sm">Anggota Tidak Ditemukan</p>
                        <p class="text-red-600 text-xs mt-1">NIP tidak terdaftar atau belum diverifikasi admin. Pastikan NIP yang Anda masukkan benar.</p>
                    </div>
                </div>
                @endif

                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold text-lg py-3.5 rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="cari">Cari Kartu Anggota</span>
                    <span wire:loading wire:target="cari">Mencari...</span>
                    <svg wire:loading.remove wire:target="cari" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>

            <div class="text-center mt-6 text-gray-400 text-xs">
                <p>Belum punya kartu anggota? <a href="{{ route('daftar.anggota') }}" class="text-emerald-600 font-semibold underline hover:text-emerald-700">Daftar Sekarang</a></p>
            </div>
        </div>
        @endif

        {{-- Member Card --}}
        @if($anggota)
        <div class="space-y-6">
            {{-- Action buttons --}}
            <div class="flex flex-wrap items-center justify-between gap-4 print:hidden">
                <button wire:click="resetCari" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-semibold text-sm transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Cari NIP Lain
                </button>
                <div class="flex items-center gap-3">
                    @if(!$template)
                    {{-- Toggle Orientation (only when no template is active) --}}
                    <div class="flex items-center bg-gray-100 rounded-xl p-1">
                        <button onclick="setOrientation('horizontal')" id="btn-horizontal" class="px-3 py-2 text-xs font-semibold rounded-lg transition-all duration-200 bg-white text-emerald-700 shadow-sm">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                Horizontal
                            </span>
                        </button>
                        <button onclick="setOrientation('vertical')" id="btn-vertical" class="px-3 py-2 text-xs font-semibold rounded-lg transition-all duration-200 text-gray-500 hover:text-gray-700">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8"/></svg>
                                Vertikal
                            </span>
                        </button>
                    </div>
                    @endif
                    <button onclick="printKartu(this)" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Cetak Kartu
                    </button>
                </div>
            </div>

            {{-- ======================== TEMPLATE-BASED CARD ======================== --}}
            @if($template && $template->background_image)
                @if($template->orientation === 'horizontal')
                <div id="card-horizontal" class="mx-auto" style="max-width: 540px;">
                    <div id="kartu-horizontal" class="kartu-font relative overflow-hidden rounded-2xl shadow-2xl" style="aspect-ratio: 8.56 / 5.398;">
                        {{-- Background Image --}}
                        <img src="{{ asset('storage/' . $template->background_image) }}" alt="Card Background" class="absolute inset-0 w-full h-full object-cover" />
                        
                        {{-- Overlay --}}
                        <div class="absolute inset-0" style="background-color: {{ $template->overlay_color }}; opacity: {{ $template->overlay_opacity }};"></div>
                        
                        {{-- Content with absolute positioning based on template settings --}}
                        <div class="relative h-full w-full">
                            {{-- Logo --}}
                            @php $logoPos = $template->logo_position ?? ['x' => 5, 'y' => 5]; @endphp
                            <div class="absolute" style="left: {{ $logoPos['x'] ?? 5 }}%; top: {{ $logoPos['y'] ?? 5 }}%;">
                                <div class="w-10 h-10 bg-white/15 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20">
                                    @if(isset($site_logo) && $site_logo)
                                        <img src="{{ asset('storage/' . $site_logo) }}" alt="Logo" class="w-7 h-7 object-contain" />
                                    @else
                                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-7 h-7 object-contain" />
                                    @endif
                                </div>
                            </div>

                            {{-- Photo --}}
                            @php $photoPos = $template->photo_position ?? ['x' => 5, 'y' => 30, 'width' => 20, 'height' => 40]; @endphp
                            <div class="absolute overflow-hidden rounded-xl border-2 border-white/30 shadow-xl" style="left: {{ $photoPos['x'] ?? 5 }}%; top: {{ $photoPos['y'] ?? 30 }}%; width: {{ $photoPos['width'] ?? 20 }}%; height: {{ $photoPos['height'] ?? 40 }}%;">
                                @if($anggota->foto)
                                    <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto" class="w-full h-full object-cover" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-emerald-600/50">
                                        <svg class="w-8 h-8 text-white/50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Name --}}
                            @php $namePos = $template->name_position ?? ['x' => 30, 'y' => 35, 'fontSize' => 14, 'color' => '#ffffff']; @endphp
                            <div class="absolute" style="left: {{ $namePos['x'] ?? 30 }}%; top: {{ $namePos['y'] ?? 35 }}%;">
                                <p class="text-[8px] font-bold uppercase tracking-[0.2em] opacity-70" style="color: {{ $namePos['color'] ?? '#ffffff' }};">Nama Lengkap</p>
                                <p class="font-bold leading-tight truncate" style="font-size: {{ $namePos['fontSize'] ?? 14 }}px; color: {{ $namePos['color'] ?? '#ffffff' }};">{{ $anggota->nama }}</p>
                            </div>

                            {{-- NIP --}}
                            @php $nipPos = $template->nip_position ?? ['x' => 30, 'y' => 50, 'fontSize' => 16, 'color' => '#ffffff']; @endphp
                            <div class="absolute" style="left: {{ $nipPos['x'] ?? 30 }}%; top: {{ $nipPos['y'] ?? 50 }}%;">
                                <p class="text-[8px] font-bold uppercase tracking-[0.2em] opacity-70" style="color: {{ $nipPos['color'] ?? '#ffffff' }};">NIP</p>
                                <p class="font-extrabold tracking-wider font-mono" style="font-size: {{ $nipPos['fontSize'] ?? 16 }}px; color: {{ $nipPos['color'] ?? '#ffffff' }};">{{ $anggota->nip }}</p>
                            </div>

                            {{-- Institution --}}
                            @if($anggota->institusi)
                            @php $instPos = $template->institution_position ?? ['x' => 30, 'y' => 62, 'fontSize' => 11, 'color' => '#ffffff']; @endphp
                            <div class="absolute" style="left: {{ $instPos['x'] ?? 30 }}%; top: {{ $instPos['y'] ?? 62 }}%;">
                                <p class="text-[8px] font-bold uppercase tracking-[0.2em] opacity-70" style="color: {{ $instPos['color'] ?? '#ffffff' }};">Institusi</p>
                                <p class="font-semibold truncate" style="font-size: {{ $instPos['fontSize'] ?? 11 }}px; color: {{ $instPos['color'] ?? '#ffffff' }};">{{ $anggota->institusi }}</p>
                            </div>
                            @endif

                            {{-- Validity --}}
                            @php $validPos = $template->validity_position ?? ['x' => 5, 'y' => 90, 'fontSize' => 8, 'color' => '#ffffff']; @endphp
                            <div class="absolute" style="left: {{ $validPos['x'] ?? 5 }}%; top: {{ $validPos['y'] ?? 90 }}%;">
                                <p class="font-medium opacity-60" style="font-size: {{ $validPos['fontSize'] ?? 8 }}px; color: {{ $validPos['color'] ?? '#ffffff' }};">Berlaku: {{ $anggota->approved_at ? $anggota->approved_at->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                {{-- Vertical Template --}}
                <div id="card-vertical" class="mx-auto" style="max-width: 320px;">
                    <div id="kartu-vertical" class="kartu-font relative overflow-hidden rounded-2xl shadow-2xl" style="aspect-ratio: 5.398 / 8.56;">
                        {{-- Background Image --}}
                        <img src="{{ asset('storage/' . $template->background_image) }}" alt="Card Background" class="absolute inset-0 w-full h-full object-cover" />
                        
                        {{-- Overlay --}}
                        <div class="absolute inset-0" style="background-color: {{ $template->overlay_color }}; opacity: {{ $template->overlay_opacity }};"></div>
                        
                        {{-- Content with absolute positioning --}}
                        <div class="relative h-full w-full">
                            {{-- Logo --}}
                            @php $logoPos = $template->logo_position ?? ['x' => 35, 'y' => 3]; @endphp
                            <div class="absolute" style="left: {{ $logoPos['x'] ?? 35 }}%; top: {{ $logoPos['y'] ?? 3 }}%;">
                                <div class="w-9 h-9 bg-white/15 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20">
                                    @if(isset($site_logo) && $site_logo)
                                        <img src="{{ asset('storage/' . $site_logo) }}" alt="Logo" class="w-6 h-6 object-contain" />
                                    @else
                                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-6 h-6 object-contain" />
                                    @endif
                                </div>
                            </div>

                            {{-- Photo --}}
                            @php $photoPos = $template->photo_position ?? ['x' => 25, 'y' => 20, 'width' => 50, 'height' => 30]; @endphp
                            <div class="absolute overflow-hidden rounded-xl border-2 border-white/30 shadow-xl" style="left: {{ $photoPos['x'] ?? 25 }}%; top: {{ $photoPos['y'] ?? 20 }}%; width: {{ $photoPos['width'] ?? 50 }}%; height: {{ $photoPos['height'] ?? 30 }}%;">
                                @if($anggota->foto)
                                    <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto" class="w-full h-full object-cover" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-emerald-600/50">
                                        <svg class="w-10 h-10 text-white/50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Name --}}
                            @php $namePos = $template->name_position ?? ['x' => 10, 'y' => 55, 'fontSize' => 14, 'color' => '#ffffff']; @endphp
                            <div class="absolute text-center" style="left: {{ $namePos['x'] ?? 10 }}%; top: {{ $namePos['y'] ?? 55 }}%; right: {{ $namePos['x'] ?? 10 }}%;">
                                <p class="text-[8px] font-bold uppercase tracking-[0.2em] opacity-60" style="color: {{ $namePos['color'] ?? '#ffffff' }};">Nama Lengkap</p>
                                <p class="font-bold leading-tight" style="font-size: {{ $namePos['fontSize'] ?? 14 }}px; color: {{ $namePos['color'] ?? '#ffffff' }};">{{ $anggota->nama }}</p>
                            </div>

                            {{-- NIP --}}
                            @php $nipPos = $template->nip_position ?? ['x' => 10, 'y' => 68, 'fontSize' => 16, 'color' => '#ffffff']; @endphp
                            <div class="absolute text-center" style="left: {{ $nipPos['x'] ?? 10 }}%; top: {{ $nipPos['y'] ?? 68 }}%; right: {{ $nipPos['x'] ?? 10 }}%;">
                                <p class="text-[7px] font-bold uppercase tracking-[0.2em] opacity-60" style="color: {{ $nipPos['color'] ?? '#ffffff' }};">NIP</p>
                                <p class="font-extrabold tracking-widest font-mono" style="font-size: {{ $nipPos['fontSize'] ?? 16 }}px; color: {{ $nipPos['color'] ?? '#ffffff' }};">{{ $anggota->nip }}</p>
                            </div>

                            {{-- Institution --}}
                            @if($anggota->institusi)
                            @php $instPos = $template->institution_position ?? ['x' => 10, 'y' => 78, 'fontSize' => 11, 'color' => '#ffffff']; @endphp
                            <div class="absolute text-center" style="left: {{ $instPos['x'] ?? 10 }}%; top: {{ $instPos['y'] ?? 78 }}%; right: {{ $instPos['x'] ?? 10 }}%;">
                                <p class="text-[8px] font-bold uppercase tracking-[0.2em] opacity-60" style="color: {{ $instPos['color'] ?? '#ffffff' }};">Institusi</p>
                                <p class="font-semibold" style="font-size: {{ $instPos['fontSize'] ?? 11 }}px; color: {{ $instPos['color'] ?? '#ffffff' }};">{{ $anggota->institusi }}</p>
                            </div>
                            @endif

                            {{-- Validity --}}
                            @php $validPos = $template->validity_position ?? ['x' => 10, 'y' => 92, 'fontSize' => 8, 'color' => '#ffffff']; @endphp
                            <div class="absolute text-center" style="left: {{ $validPos['x'] ?? 10 }}%; top: {{ $validPos['y'] ?? 92 }}%; right: {{ $validPos['x'] ?? 10 }}%;">
                                <p class="font-medium opacity-60" style="font-size: {{ $validPos['fontSize'] ?? 8 }}px; color: {{ $validPos['color'] ?? '#ffffff' }};">Berlaku sejak: {{ $anggota->approved_at ? $anggota->approved_at->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            @else
            {{-- ======================== DEFAULT HORIZONTAL CARD (no template) ======================== --}}
            <div id="card-horizontal" class="mx-auto" style="max-width: 540px;">
                <div id="kartu-horizontal" class="kartu-font relative overflow-hidden rounded-2xl shadow-2xl" style="aspect-ratio: 8.56 / 5.398;">
                    {{-- Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 via-emerald-700 to-teal-600"></div>
                    
                    {{-- Decorative Elements --}}
                    <div class="absolute inset-0">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full"></div>
                        <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full"></div>
                        <div class="absolute top-1/2 right-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-2xl"></div>
                        {{-- Geometric accent --}}
                        <div class="absolute bottom-0 right-0 w-48 h-48 opacity-[0.03]">
                            <svg viewBox="0 0 200 200" fill="white"><polygon points="200,200 200,0 0,200"/></svg>
                        </div>
                        {{-- Top accent line --}}
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 via-emerald-300 to-teal-400"></div>
                    </div>
                    
                    {{-- Content --}}
                    <div class="relative h-full flex flex-col justify-between p-5">
                        {{-- Header --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/15 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20">
                                    @if(isset($site_logo) && $site_logo)
                                        <img src="{{ asset('storage/' . $site_logo) }}" alt="Logo" class="w-7 h-7 object-contain" />
                                    @else
                                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-7 h-7 object-contain" />
                                    @endif
                                </div>
                                <div>
                                    <p class="text-white/80 text-[9px] font-bold tracking-widest uppercase">Perpustakaan</p>
                                    <p class="text-white text-[11px] font-extrabold tracking-wide">KEMENTERIAN AGAMA RI</p>
                                </div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-md px-3 py-1 rounded-full border border-white/20">
                                <span class="text-[8px] font-bold text-emerald-200 uppercase tracking-widest">Kartu Anggota</span>
                            </div>
                        </div>

                        {{-- Main Content --}}
                        <div class="flex items-center gap-5 flex-1 py-3">
                            {{-- Photo --}}
                            <div class="relative shrink-0">
                                <div class="w-16 h-20 rounded-xl overflow-hidden border-2 border-white/30 shadow-xl bg-white/10">
                                    @if($anggota->foto)
                                        <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto" class="w-full h-full object-cover" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-emerald-600/50">
                                            <svg class="w-8 h-8 text-white/50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Details --}}
                            <div class="flex-1 min-w-0 space-y-2">
                                <div>
                                    <p class="text-emerald-300/70 text-[8px] font-bold uppercase tracking-[0.2em]">Nama Lengkap</p>
                                    <p class="text-white font-bold text-sm leading-tight truncate">{{ $anggota->nama }}</p>
                                </div>
                                <div>
                                    <p class="text-emerald-300/70 text-[8px] font-bold uppercase tracking-[0.2em]">NIP</p>
                                    <p class="text-white font-extrabold text-base tracking-wider font-mono">{{ $anggota->nip }}</p>
                                </div>
                                @if($anggota->institusi)
                                <div>
                                    <p class="text-emerald-300/70 text-[8px] font-bold uppercase tracking-[0.2em]">Institusi</p>
                                    <p class="text-white/90 font-semibold text-[11px] truncate">{{ $anggota->institusi }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="flex items-center justify-between pt-1 border-t border-white/10">
                            <p class="text-white/40 text-[8px] font-medium">Berlaku: {{ $anggota->approved_at ? $anggota->approved_at->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================== DEFAULT VERTICAL CARD (no template) ======================== --}}
            <div id="card-vertical" class="mx-auto hidden" style="max-width: 320px;">
                <div id="kartu-vertical" class="kartu-font relative overflow-hidden rounded-2xl shadow-2xl" style="aspect-ratio: 5.398 / 8.56;">
                    {{-- Background --}}
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-800 via-emerald-700 to-teal-700"></div>
                    
                    {{-- Decorative Elements --}}
                    <div class="absolute inset-0">
                        <div class="absolute -top-16 -right-16 w-48 h-48 bg-white/5 rounded-full"></div>
                        <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-white/5 rounded-full"></div>
                        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl"></div>
                        {{-- Top accent line --}}
                        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-yellow-400 via-emerald-300 to-teal-400"></div>
                    </div>
                    
                    {{-- Content --}}
                    <div class="relative h-full flex flex-col p-5">
                        {{-- Header --}}
                        <div class="flex items-center justify-center gap-3 mb-4">
                            <div class="w-9 h-9 bg-white/15 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20">
                                @if(isset($site_logo) && $site_logo)
                                    <img src="{{ asset('storage/' . $site_logo) }}" alt="Logo" class="w-6 h-6 object-contain" />
                                @else
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-6 h-6 object-contain" />
                                @endif
                            </div>
                            <div class="text-center">
                                <p class="text-white/80 text-[8px] font-bold tracking-widest uppercase">Perpustakaan</p>
                                <p class="text-white text-[10px] font-extrabold tracking-wide">KEMENTERIAN AGAMA RI</p>
                            </div>
                        </div>

                        <div class="mx-auto bg-white/10 backdrop-blur-md px-3 py-1 rounded-full border border-white/20 mb-5">
                            <span class="text-[8px] font-bold text-emerald-200 uppercase tracking-widest">Kartu Anggota</span>
                        </div>

                        {{-- Photo --}}
                        <div class="flex justify-center mb-5">
                            <div class="relative">
                                <div class="w-24 h-28 rounded-xl overflow-hidden border-2 border-white/30 shadow-xl bg-white/10">
                                    @if($anggota->foto)
                                        <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto" class="w-full h-full object-cover" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-emerald-600/50">
                                            <svg class="w-10 h-10 text-white/50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="flex-1 space-y-3 text-center">
                            <div>
                                <p class="text-emerald-300/60 text-[8px] font-bold uppercase tracking-[0.2em]">Nama Lengkap</p>
                                <p class="text-white font-bold text-sm leading-tight">{{ $anggota->nama }}</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl py-2.5 px-4 border border-white/10">
                                <p class="text-emerald-300/60 text-[7px] font-bold uppercase tracking-[0.2em] mb-0.5">NIP</p>
                                <p class="text-white font-extrabold text-base tracking-widest font-mono">{{ $anggota->nip }}</p>
                            </div>
                            @if($anggota->institusi)
                            <div>
                                <p class="text-emerald-300/60 text-[8px] font-bold uppercase tracking-[0.2em]">Institusi</p>
                                <p class="text-white/90 font-semibold text-xs">{{ $anggota->institusi }}</p>
                            </div>
                            @endif
                        </div>

                        {{-- Footer --}}
                        <div class="mt-auto pt-4 border-t border-white/10 text-center">
                            <p class="text-white/40 text-[8px] font-medium">Berlaku sejak: {{ $anggota->approved_at ? $anggota->approved_at->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Info box --}}
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-start gap-3 print:hidden max-w-xl mx-auto">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <div>
                    <p class="text-emerald-800 font-semibold text-sm">Petunjuk Cetak</p>
                    <p class="text-emerald-700 text-xs mt-1">Klik tombol "Cetak Kartu" untuk mencetak kartu anggota. Pilih orientasi horizontal atau vertikal sesuai kebutuhan Anda.</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Scripts --}}
    <script>
        let currentOrientation = 'horizontal';

        function setOrientation(type) {
            currentOrientation = type;
            const hCard = document.getElementById('card-horizontal');
            const vCard = document.getElementById('card-vertical');
            const btnH = document.getElementById('btn-horizontal');
            const btnV = document.getElementById('btn-vertical');

            if (!hCard || !vCard) return;

            if (type === 'horizontal') {
                hCard.classList.remove('hidden');
                vCard.classList.add('hidden');
                if (btnH) btnH.className = 'px-3 py-2 text-xs font-semibold rounded-lg transition-all duration-200 bg-white text-emerald-700 shadow-sm';
                if (btnV) btnV.className = 'px-3 py-2 text-xs font-semibold rounded-lg transition-all duration-200 text-gray-500 hover:text-gray-700';
            } else {
                hCard.classList.add('hidden');
                vCard.classList.remove('hidden');
                if (btnV) btnV.className = 'px-3 py-2 text-xs font-semibold rounded-lg transition-all duration-200 bg-white text-emerald-700 shadow-sm';
                if (btnH) btnH.className = 'px-3 py-2 text-xs font-semibold rounded-lg transition-all duration-200 text-gray-500 hover:text-gray-700';
            }
        }

        function printKartu(btn) {
            window.print();
        }
    </script>

    {{-- Print Styles --}}
    <style>
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            body, html {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }
            /* Hide everything except the active card */
            body * {
                visibility: hidden !important;
            }
            #card-horizontal:not(.hidden),
            #card-horizontal:not(.hidden) *,
            #card-vertical:not(.hidden),
            #card-vertical:not(.hidden) * {
                visibility: visible !important;
            }
            #card-horizontal:not(.hidden),
            #card-vertical:not(.hidden) {
                position: fixed !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                margin: 0 !important;
                max-width: none !important;
            }
            #card-horizontal:not(.hidden) {
                width: 86mm !important;
                height: auto !important;
            }
            #card-vertical:not(.hidden) {
                width: 54mm !important;
                height: auto !important;
            }
            /* Keep aspect ratio on card inner div */
            #kartu-horizontal {
                width: 86mm !important;
                height: 54mm !important;
                aspect-ratio: 8.56 / 5.398 !important;
                overflow: hidden !important;
            }
            #kartu-vertical {
                width: 54mm !important;
                height: 86mm !important;
                aspect-ratio: 5.398 / 8.56 !important;
                overflow: hidden !important;
            }
            @page {
                size: A4;
                margin: 20mm;
            }
        }
    </style>
</div>
