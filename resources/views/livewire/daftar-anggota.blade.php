<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-50 relative font-sans">
    
    {{-- Decorative Background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-100 rounded-full opacity-40 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-teal-100 rounded-full opacity-40 blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-3xl mx-auto px-4 py-12 md:py-20">

        {{-- Header --}}
        <div class="text-center mb-10">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 text-sm font-semibold mb-6 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Beranda
            </a>

            {{-- Logged-in user badge --}}
            <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-2 rounded-full text-sm font-semibold mb-5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Masuk sebagai: {{ auth()->user()->name }}
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">Daftar Anggota Perpustakaan</h1>
            <p class="text-gray-500 max-w-lg mx-auto">Isi formulir pendaftaran di bawah ini. Setelah diverifikasi oleh admin, Anda akan mendapatkan kartu anggota digital.</p>
        </div>

        @if($successMessage)
            {{-- Success State --}}
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-8 text-center text-white">
                    <div class="mx-auto w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-5">
                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-2">Pendaftaran Berhasil!</h2>
                    <p class="text-emerald-100 text-sm">Data Anda telah dikirim dan menunggu verifikasi admin.</p>
                </div>
                <div class="p-8 space-y-4">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <div>
                            <p class="text-amber-800 font-semibold text-sm">Menunggu Verifikasi</p>
                            <p class="text-amber-700 text-xs mt-1">Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Setelah disetujui, Anda bisa mencetak kartu anggota.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wider mb-3">Detail Pendaftaran</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">NIP</span>
                                <span class="font-semibold text-gray-800 font-mono">{{ $submittedAnggota->nip }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nama</span>
                                <span class="font-semibold text-gray-800">{{ $submittedAnggota->nama }}</span>
                            </div>
                            @if($submittedAnggota->email)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Email</span>
                                <span class="font-semibold text-gray-800">{{ $submittedAnggota->email }}</span>
                            </div>
                            @endif
                            @if($submittedAnggota->institusi)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Institusi</span>
                                <span class="font-semibold text-gray-800">{{ $submittedAnggota->institusi }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-500">Status</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                    <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                                    Menunggu Verifikasi
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center pt-4">
                        <button wire:click="resetForm" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            Daftar Anggota Lain
                        </button>
                    </div>
                </div>
            </div>
        @else
            {{-- Registration Form --}}
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-8 py-6">
                    <h2 class="text-white font-bold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        Formulir Pendaftaran
                    </h2>
                    <p class="text-emerald-100 text-sm mt-1">Lengkapi data diri Anda di bawah ini</p>
                </div>

                <form wire:submit="submit" class="p-8 space-y-6">

                    {{-- Section 1: Identitas Anggota --}}
                    <div class="border-b border-gray-100 pb-5">
                        <h3 class="text-sm font-bold text-emerald-800 dark:text-emerald-450 uppercase tracking-wider mb-4">I. Identitas Anggota</h3>
                        <div class="space-y-4">
                            {{-- Photo Upload --}}
                            <div class="flex justify-center mb-4">
                                <div class="relative group" x-data="{ previewUrl: null }">
                                    <div class="w-28 h-28 rounded-full border-4 border-dashed border-gray-200 flex items-center justify-center overflow-hidden bg-gray-50 group-hover:border-emerald-400 transition-colors cursor-pointer"
                                         @click="$refs.fotoInput.click()">
                                        @if($foto)
                                            <img src="{{ $foto->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview" />
                                        @else
                                            <div class="text-center">
                                                <svg class="w-8 h-8 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                <span class="text-xs text-gray-400 mt-1 block">Upload Foto</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" wire:model="foto" x-ref="fotoInput" accept="image/*" class="hidden" />
                                    <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-lg cursor-pointer group-hover:bg-emerald-600 transition"
                                         @click="$refs.fotoInput.click()">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    </div>
                                </div>
                            </div>
                            @error('foto') <p class="text-red-500 text-xs text-center font-semibold mb-3">{{ $message }}</p> @enderror

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- ID Anggota --}}
                                <div>
                                    <label for="nip" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">ID Anggota / NIP <span class="text-red-400">*</span></label>
                                    <input type="text" id="nip" wire:model="nip"
                                        class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all @error('nip') border-red-400 bg-red-50 @enderror"
                                        placeholder="Masukkan NIP / ID unik">
                                    @error('nip') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                                </div>

                                {{-- Nama Anggota --}}
                                <div>
                                    <label for="nama" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nama Anggota <span class="text-red-400">*</span></label>
                                    <input type="text" id="nama" wire:model="nama"
                                        class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all @error('nama') border-red-400 bg-red-50 @enderror"
                                        placeholder="Masukkan nama lengkap">
                                    @error('nama') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Jenis Kelamin --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Jenis Kelamin <span class="text-red-400">*</span></label>
                                    <div class="flex items-center gap-6 py-2.5">
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                            <input type="radio" value="Laki-laki" wire:model="gender" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                            Laki-laki
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                            <input type="radio" value="Perempuan" wire:model="gender" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                            Perempuan
                                        </label>
                                    </div>
                                    @error('gender') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div>
                                    <label for="birth_date" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Tanggal Lahir <span class="text-red-400">*</span></label>
                                    <input type="date" id="birth_date" wire:model="birth_date"
                                        class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all @error('birth_date') border-red-400 bg-red-50 @enderror">
                                    @error('birth_date') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Tipe Keanggotaan --}}
                                <div>
                                    <label for="member_type_id" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Tipe Keanggotaan <span class="text-red-400">*</span></label>
                                    <select id="member_type_id" wire:model="member_type_id"
                                        class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all">
                                        @foreach($memberTypes as $type)
                                            <option value="{{ $type->member_type_id }}">{{ $type->member_type_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('member_type_id') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                                </div>

                                {{-- Institusi --}}
                                <div>
                                    <label for="institusi" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Institusi / Instansi</label>
                                    <input type="text" id="institusi" wire:model="institusi"
                                        class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all"
                                        placeholder="Nama instansi / universitas">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Informasi Kontak --}}
                    <div class="border-b border-gray-100 pb-5">
                        <h3 class="text-sm font-bold text-emerald-800 dark:text-emerald-450 uppercase tracking-wider mb-4">II. Informasi Kontak</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Alamat --}}
                                <div>
                                    <label for="alamat" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Alamat</label>
                                    <textarea id="alamat" wire:model="alamat" rows="2"
                                        class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all resize-none"
                                        placeholder="Alamat lengkap tinggal saat ini"></textarea>
                                </div>

                                {{-- Alamat Surat --}}
                                <div>
                                    <label for="alamat_surat" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Alamat Surat / Korespondensi</label>
                                    <textarea id="alamat_surat" wire:model="alamat_surat" rows="2"
                                        class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all resize-none"
                                        placeholder="Alamat surat menyurat jika berbeda"></textarea>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                {{-- Kode Pos --}}
                                <div>
                                    <label for="kode_pos" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Kode Pos</label>
                                    <input type="text" id="kode_pos" wire:model="kode_pos"
                                        class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all"
                                        placeholder="Kode Pos">
                                </div>

                                {{-- Nomor Telepon --}}
                                <div>
                                    <label for="no_hp" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nomor Telepon / HP</label>
                                    <input type="text" id="no_hp" wire:model="no_hp"
                                        class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all"
                                        placeholder="08xxxxxxxxxx">
                                </div>

                                {{-- Nomor Faks --}}
                                <div>
                                    <label for="no_faks" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nomor Faks</label>
                                    <input type="text" id="no_faks" wire:model="no_faks"
                                        class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all"
                                        placeholder="Nomor Faks">
                                </div>
                            </div>

                            {{-- Surel --}}
                            <div>
                                <label for="email" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Surel / Email</label>
                                <input type="email" id="email" wire:model="email"
                                    class="w-full px-4 py-2.5 border border-gray-200 text-gray-800 text-sm rounded-xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all @error('email') border-red-400 bg-red-50 @enderror"
                                    placeholder="email@contoh.com">
                                @error('email') <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>



                    {{-- Submit Button --}}
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold text-lg py-3.5 rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="submit">Kirim Pendaftaran</span>
                            <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                Mengirim...
                            </span>
                            <svg wire:loading.remove wire:target="submit" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Info --}}
            <div class="text-center mt-8 text-gray-400 text-xs">
                <p>Sudah terdaftar? Gunakan NIP Anda untuk check-in di <a href="{{ route('buku.tamu') }}" class="text-emerald-600 font-semibold underline hover:text-emerald-700">Buku Tamu</a>.</p>
            </div>
        @endif
    </div>
</div>
