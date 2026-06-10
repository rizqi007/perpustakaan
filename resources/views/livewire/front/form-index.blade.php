<div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Custom Header --}}
        <div class="lg:col-span-2">
            <h4 class="text-sm font-bold text-emerald-600 uppercase tracking-wide mb-1">LAYANAN DIGITAL</h4>
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Formulir Online</h1>
            <div class="h-1 w-20 bg-emerald-500 mb-6 rounded"></div>
            <p class="text-gray-600 dark:text-gray-400 mb-10 text-lg">
                Isi formulir pelayanan perpustakaan secara online dengan mudah dan cepat.
            </p>

            <div class="space-y-6">
                @foreach($forms as $form)
                    <a href="{{ $form->slug === 'pengajuan-isbn' ? route('dashboard') : route('form.show', $form->slug) }}" class="group block p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition duration-300 flex items-start gap-4">
                        <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition duration-300">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 transition">{{ $form->title }}</h3>
                            <p class="text-gray-500 text-sm mt-1 line-clamp-2 md:line-clamp-none">{{ Str::limit(strip_tags($form->description), 120) }}</p>
                        </div>
                         <div class="self-center opacity-0 group-hover:opacity-100 transition duration-300 transform translate-x-[-10px] group-hover:translate-x-0">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                         </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Calendar Section --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 sticky top-24">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Jadwal Quota & Availability</h2>
                    <p class="text-xs text-gray-500 mt-1">Cek ketersediaan tanggal booking</p>
                </div>
                
                {{-- Calendar --}}
                <div class="mb-4 flex items-center justify-between">
                     <button wire:click="prevMonth" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-600 dark:text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                     </button>
                     <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 uppercase tracking-wider">{{ $currentMonthName }}</span>
                     <button wire:click="nextMonth" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-600 dark:text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                     </button>
                </div>

                <div class="grid grid-cols-7 gap-1 text-center mb-2">
                    @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $day)
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wide py-2">{{ $day }}</div>
                    @endforeach
                </div>

                <div class="grid grid-cols-7 gap-1">
                    @foreach($calendarData as $day)
                        <div class="relative aspect-square flex flex-col items-center justify-center rounded-lg text-sm transition duration-200
                             {{ $day['isCurrentMonth'] ? 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700' : 'text-gray-300 dark:text-gray-600' }}">
                             
                             <span class="z-10 {{ $day['date']->isToday() ? 'bg-emerald-500 text-white w-6 h-6 rounded-full flex items-center justify-center shadow-md' : '' }}">
                                 {{ $day['date']->day }}
                             </span>

                             @if(!empty($day['events']))
                                <div class="mt-1 flex gap-0.5 justify-center flex-wrap px-0.5 w-full">
                                    @foreach($day['events'] as $event)
                                         <div class="h-1.5 w-1.5 rounded-full {{ $event['class'] }}" title="{{ $event['title'] }} {{ $event['isFull'] ? '(Penuh)' : '(Tersedia)' }}"></div>
                                    @endforeach
                                </div>
                             @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 space-y-2 text-xs text-gray-500">
                     <div class="flex items-center gap-2">
                         <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                         <span>Tersedia</span>
                     </div>
                     <div class="flex items-center gap-2">
                         <div class="h-2 w-2 rounded-full bg-red-500"></div>
                         <span>Kuota Penuh</span>
                     </div>
                </div>

            </div>
        </div>
    </div>
</div>
