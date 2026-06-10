<div class="bg-white dark:bg-gray-800 rounded-3xl p-4 md:p-6 shadow-xl ring-1 ring-gray-900/5 dark:ring-white/10" x-data>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Jadwal Nobar & Diskusi</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Cek ketersediaan tanggal booking</p>
        </div>
        
        <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-900 rounded-lg p-1">
            <button wire:click="prevMonth" class="p-1.5 hover:bg-white dark:hover:bg-gray-800 rounded-md transition shadow-sm">
                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <span class="px-3 text-sm font-semibold text-gray-900 dark:text-white min-w-[120px] text-center">
                {{ $monthName }}
            </span>
            <button wire:click="nextMonth" class="p-1.5 hover:bg-white dark:hover:bg-gray-800 rounded-md transition shadow-sm">
                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="grid grid-cols-7 gap-px bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden ring-1 ring-gray-200 dark:ring-gray-700">
        <!-- Weekday Headers -->
        @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $day)
            <div class="bg-gray-50 dark:bg-gray-900 py-2 text-center text-[10px] font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                {{ $day }}
            </div>
        @endforeach

        <!-- Days -->
        @foreach($calendarDays as $day)
            @if(is_array($day))
                <div class="bg-white dark:bg-gray-800 min-h-[80px] p-1.5 transition hover:bg-gray-50 dark:hover:bg-gray-700 relative group">
                    <div class="flex justify-between items-start">
                        <span class="text-xs font-medium {{ $day['isToday'] ? 'bg-emerald-600 text-white w-5 h-5 flex items-center justify-center rounded-full' : 'text-gray-700 dark:text-gray-300' }}">
                            {{ $day['day'] }}
                        </span>
                        @if($day['bookings']->count() > 0)
                            @php
                                $hasBlocked = $day['bookings']->contains('type', 'blocked');
                                $dotColor = $hasBlocked ? 'bg-red-500' : 'bg-emerald-500';
                                $pingColor = $hasBlocked ? 'bg-red-400' : 'bg-emerald-400';
                            @endphp
                            <span class="flex h-1.5 w-1.5 sm:hidden">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $pingColor }} opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 {{ $dotColor }}"></span>
                            </span>
                        @endif
                    </div>

                    <div class="mt-1 space-y-1">
                        @foreach($day['bookings'] as $booking)
                            @php
                                $colorClass = $booking['type'] === 'blocked' 
                                    ? 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border-red-200 dark:border-red-800'
                                    : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800';
                            @endphp
                            <div class="text-[9px] px-1 py-0.5 rounded border truncate cursor-help {{ $colorClass }}"
                                 title="{{ $booking['label'] }} {{ isset($booking['session']) ? '- ' . $booking['session'] : '' }}">
                                {{ $booking['label'] }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-gray-50/50 dark:bg-gray-900/50 min-h-[80px]"></div>
            @endif
        @endforeach
    </div>
</div>
