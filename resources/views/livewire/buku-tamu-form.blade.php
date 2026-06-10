<div class="min-h-screen bg-emerald-900 relative flex items-center justify-center overflow-hidden font-sans">
    
    {{-- Background Banner Image with Overlay --}}
    <div class="absolute inset-0 z-0">
        {{-- Banner Image --}}
        <img src="{{ asset('images/gedung.jpg') }}" alt="Background" class="w-full h-full object-cover fixed z-0" />
        
        {{-- Overlays to make text readable --}}
        <div class="fixed inset-0 bg-emerald-900/60 mix-blend-multiply z-0"></div>
        <div class="fixed inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent z-0"></div>
    </div>



    {{-- Form Container --}}
    <div class="w-full max-w-5xl mx-4 z-10">
        
        <div class="flex flex-col md:flex-row bg-white rounded-3xl overflow-hidden shadow-[0_20px_60px_-15px_rgba(0,0,0,0.5)] border border-white/20">
            
            {{-- Left Side: Form --}}
            <div class="w-full md:w-[55%] p-6 md:p-8 lg:px-12 lg:py-10 relative bg-white flex-col justify-center {{ $successMessage ? 'hidden md:flex' : 'flex' }}">
                

                    <div class="mb-8">
                        <h1 class="text-[#2b394a] text-2xl md:text-3xl font-bold mb-1">Welcome to</h1>
                        <h1 class="text-[#2b394a] text-2xl md:text-3xl font-extrabold uppercase leading-tight">PERPUSTAKAAN<br>KEMENTERIAN AGAMA RI</h1>
                        <p class="text-gray-400 text-sm mt-3 font-medium">Silakan isi Nama atau ID Anda untuk Check-In.</p>
                    </div>

                    <form wire:submit="submit" class="space-y-5">
                        <div>
                            <label for="nama" class="flex text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                NAMA LENGKAP ATAU ID
                            </label>
                            <input type="text" id="nama" wire:model.live.debounce.500ms="nama" 
                                class="w-full px-4 py-3 border border-blue-200 text-gray-800 text-base rounded-xl focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-100 transition-all duration-200 @error('nama') border-red-400 bg-red-50 focus:border-red-400 focus:ring-red-100 @enderror"
                                autofocus>
                            @error('nama') <p class="text-red-500 text-xs mt-2 font-semibold flex items-center gap-1"><svg class="w-3.5 h-3.5" x-data="{}" x-init="playErrorSound()" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="institusi" class="flex text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                INSTITUTION (INSTANSI)
                            </label>
                            <input type="text" id="institusi" wire:model="institusi"
                                class="w-full px-4 py-3 border border-gray-100 bg-gray-50/50 text-gray-800 text-base rounded-xl focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-100 transition-all duration-200 @error('institusi') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror">
                            <p class="text-gray-400 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Isi instansi / asal universitas jikalau ada.
                            </p>
                            @error('institusi') <p class="text-red-500 text-xs mt-2 font-semibold flex items-center gap-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full bg-[#186845] text-white font-bold text-lg py-3.5 rounded-xl hover:bg-[#125035] transition-all duration-200 shadow-md shadow-emerald-900/10 flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="submit">Check In Sekarang</span>
                                <span wire:loading wire:target="submit">Memproses...</span>
                                <svg wire:loading.remove wire:target="submit" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                        
                        <div class="text-center pt-6 text-gray-400 text-xs font-semibold">
                            <p>Powered by <span class="text-gray-600">Perpustakaan Kementerian Agama RI</span></p>
                        </div>
                    </form>
            </div>
            
            {{-- Right Side: Aesthetic Quote Panel or Success Message --}}
            <div class="w-full md:w-[45%] bg-[#186845] relative flex-col items-center justify-center p-8 lg:p-10 overflow-hidden {{ $successMessage ? 'flex' : 'hidden md:flex' }}">
                
                {{-- Decorative circles matching SLiMS --}}
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-black/10 rounded-full"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-white/5 rounded-full"></div>
                
                @if($successMessage)
                    <div class="relative z-10 w-full text-center text-white px-4 md:px-8 py-8" x-data="{ 
                        init() { 
                            playSuccessSound(); 
                            setTimeout(() => $wire.resetForm(), 4000); 
                        } 
                    }">
                        <div class="mx-auto w-40 h-40 bg-[#333333] rounded-full flex items-center justify-center mb-8 border-[6px] border-white shadow-xl scale-in-center overflow-hidden">
                            <svg class="w-32 h-32 fill-white mt-10" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <h2 class="text-2xl md:text-[1.75rem] font-extrabold text-white mb-6 tracking-tight leading-tight">
                            {{ $submittedName }}, terima kasih telah mencatatkan data kunjungan Anda di buku tamu kami
                        </h2>
                        <p class="text-[#a4ccbb] font-medium tracking-wide text-lg">Selamat datang kembali!</p>
                    </div>
                @elseif($anggota)
                    <div class="relative z-10 w-full text-center text-white px-4 md:px-8 py-8 transition-all duration-500 transform translate-y-0 opacity-100">
                        <div class="mx-auto w-32 h-32 md:w-40 md:h-40 bg-white rounded-full flex items-center justify-center mb-6 border-[4px] border-emerald-300 shadow-xl overflow-hidden relative">
                            @if($anggota->foto)
                                <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto {{ $anggota->nama }}" class="w-full h-full object-cover" />
                            @else
                                <svg class="w-20 h-20 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            @endif
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-2 tracking-tight">{{ $anggota->nama }}</h2>
                        <p class="text-emerald-200 font-medium text-lg">{{ $anggota->nip }}</p>
                        @if($anggota->institusi)
                            <div class="mt-4">
                                <span class="text-emerald-50 text-sm font-semibold px-4 py-1.5 bg-black/20 backdrop-blur-sm rounded-full inline-block border border-white/10 shadow-sm">{{ $anggota->institusi }}</span>
                            </div>
                        @endif
                        
                        <div class="mt-8 flex justify-center">
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-100/80 bg-emerald-900/50 px-3 py-1 rounded-full uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Verified Member
                            </span>
                        </div>
                    </div>
                @else
                    <div class="relative z-10 w-full text-center text-white px-4 md:px-8" 
                     x-data="{
                        quotes: [
                            { text: 'Membaca adalah alat paling dasar untuk meraih hidup yang baik.', author: 'Joseph Addison' },
                            { text: 'Buku adalah jendela dunia, dan membaca adalah kuncinya.', author: 'Proverb' },
                            { text: 'Ada kejahatan yang lebih buruk daripada membakar buku. Salah satunya adalah tidak membacanya.', author: 'Joseph Brodsky' },
                            { text: 'Semakin banyak engkau membaca, semakin banyak pula hal yang engkau ketahui.', author: 'Dr. Seuss' }
                        ],
                        current: 0,
                        init() {
                            setInterval(() => {
                                this.current = (this.current + 1) % this.quotes.length;
                            }, 5000);
                        }
                     }">
                     
                    <div class="relative w-full min-h-[180px] flex items-center justify-center mt-4">
                        <template x-for="(quote, index) in quotes" :key="index">
                            <div x-show="current === index" 
                                 x-transition:enter="transition ease-out duration-500 delay-300" 
                                 x-transition:enter-start="opacity-0 translate-y-4" 
                                 x-transition:enter-end="opacity-100 translate-y-0" 
                                 x-transition:leave="transition ease-in duration-300 absolute top-1/2 left-0 right-0 -translate-y-1/2" 
                                 x-transition:leave-start="opacity-100 translate-y-0" 
                                 x-transition:leave-end="opacity-0 -translate-y-4"
                                 class="w-full absolute flex flex-col justify-center">
                                <p class="text-xl md:text-2xl font-medium italic leading-relaxed mb-4" x-text="'&quot;' + quote.text + '&quot;'"></p>
                                <p class="text-emerald-200 font-semibold tracking-wide text-sm md:text-base">— <span x-text="quote.author"></span></p>
                            </div>
                        </template>
                    </div>
                @endif
            </div>

        </div>
    </div>
    
    <script>
        function playSuccessSound() {
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                
                // Play a pleasant double-chime (ding-ding) like SLiMS
                const playTone = (freq, startTime, duration) => {
                    const oscillator = audioCtx.createOscillator();
                    const gainNode = audioCtx.createGain();
                    
                    oscillator.connect(gainNode);
                    gainNode.connect(audioCtx.destination);
                    
                    oscillator.type = 'sine';
                    oscillator.frequency.value = freq;
                    
                    gainNode.gain.setValueAtTime(0, startTime);
                    gainNode.gain.linearRampToValueAtTime(0.5, startTime + 0.05);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, startTime + duration);
                    
                    oscillator.start(startTime);
                    oscillator.stop(startTime + duration);
                };
                
                const now = audioCtx.currentTime;
                playTone(880, now, 0.4);      // A5
                playTone(1108.73, now + 0.15, 0.6); // C#6
            } catch (e) {
                console.log("Audio not supported or blocked");
            }
        }

        function playErrorSound() {
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioCtx.createOscillator();
                const gainNode = audioCtx.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioCtx.destination);
                
                oscillator.type = 'square';
                oscillator.frequency.value = 150;
                
                gainNode.gain.setValueAtTime(0, audioCtx.currentTime);
                gainNode.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.05);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
                
                oscillator.start(audioCtx.currentTime);
                oscillator.stop(audioCtx.currentTime + 0.3);
            } catch (e) {
                console.log("Audio not supported");
            }
        }
    </script>
</div>
