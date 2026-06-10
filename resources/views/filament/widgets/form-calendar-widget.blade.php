<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                Kalender Kegiatan & Kuota
            </h2>
            <div class="flex items-center gap-2">
                <button wire:click="prevMonth" class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <x-heroicon-m-chevron-left class="w-5 h-5 text-gray-500" />
                </button>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 min-w-[120px] text-center">
                    {{ \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1)->translatedFormat('F Y') }}
                </span>
                <button wire:click="nextMonth" class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <x-heroicon-m-chevron-right class="w-5 h-5 text-gray-500" />
                </button>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-px bg-gray-200 dark:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
            {{-- Header --}}
            @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $dayName)
                <div class="bg-gray-50 dark:bg-gray-800 p-2 text-center text-xs font-semibold text-gray-500 uppercase">
                    {{ $dayName }}
                </div>
            @endforeach

            {{-- Days --}}
            @foreach($days as $day)
                <div class="min-h-[100px] bg-white dark:bg-gray-900 p-2 {{ !$day['isCurrentMonth'] ? 'bg-gray-50/50 dark:bg-gray-800/50' : '' }}">
                    <div class="flex justify-between items-start">
                        <span class="text-sm font-medium {{ $day['isToday'] ? 'bg-emerald-500 text-white w-6 h-6 rounded-full flex items-center justify-center' : 'text-gray-700 dark:text-gray-300' }}">
                            {{ $day['day'] }}
                        </span>
                    </div>

                    <div class="mt-1 space-y-1">
                        @foreach($forms as $form)
                            @php
                                $start = $form['start'];
                                $end = $form['end'] ?? $start;
                                $currentDate = $day['date'];
                                $show = $currentDate >= $start && $currentDate <= $end;
                            @endphp

                            @if($show)
                                <div class="text-xs p-1.5 rounded border {{ $form['isFull'] ? 'bg-red-50 border-red-100 text-red-700 dark:bg-red-900/20 dark:border-red-800 dark:text-red-300' : 'bg-emerald-50 border-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:border-emerald-800 dark:text-emerald-300' }}">
                                    <div class="font-semibold truncate" title="{{ $form['title'] }}">{{ $form['title'] }}</div>
                                    <div class="flex items-center justify-between mt-0.5">
                                        <span>Peserta:</span>
                                        <span class="font-bold">
                                            {{ $form['registered'] }}
                                            @if($form['quota'])
                                                <span class="text-gray-400 dark:text-gray-500">/{{ $form['quota'] }}</span>
                                            @endif
                                        </span>
                                    </div>
                                    
                                    {{-- Participant Names --}}
                                    @if(!empty($form['participants']))
                                        <div class="mt-1 pt-1 border-t border-gray-200 dark:border-gray-600/50 flex flex-col gap-0.5">
                                            @foreach(array_slice($form['participants'], 0, 3) as $name)
                                                <span class="text-[10px] truncate block opacity-80">- {{ $name }}</span>
                                            @endforeach
                                            @if(count($form['participants']) > 3)
                                                <span class="text-[10px] opacity-60 italic">+{{ count($form['participants']) - 3 }} lainnya</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
