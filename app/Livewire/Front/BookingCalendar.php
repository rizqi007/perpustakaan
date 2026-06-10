<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\FormSubmission;
use Carbon\Carbon;

class BookingCalendar extends Component
{
    public $currentMonth;
    public $currentYear;
    
    public function mount()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function prevMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function getDaysProperty()
    {
        $firstDay = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $firstDay->daysInMonth;
        // Adjust start day (Carbon dayOfWeekIso: 1=Mon, 7=Sun)
        $startDayOfWeek = $firstDay->dayOfWeekIso; 
        
        $calendar = [];
        
        // Empty cells before start of month
        for ($i = 1; $i < $startDayOfWeek; $i++) {
            $calendar[] = null;
        }

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, $day);
            
            // Fetch approved bookings for this date
            // Optimization: Could fetch all for the month once and map them
            $dateStr = $date->format('Y-m-d');
            
            // 1. Fetch FormBlockedDate for this date
            $blockedDates = \App\Models\FormBlockedDate::where('booking_date', $dateStr)->get();

            // 2. Fetch specific FormSubmissions (for Nobar form usually)
            // Ideally we should know which form this calendar is for.
            // Assuming we check ALL forms or specifically 'pendaftaran-nobar-dan-diskusi-film' if hardcoded?
            // The previous code did: FormSubmission::whereDate('booking_date')...
            // It seems it was getting ALL submissions for ANY form on that date.
            // Let's stick to that for now, but filter by approved/pending based on requirement.
            
            $submissions = FormSubmission::whereHas('form', function ($query) {
                $query->where('slug', '!=', 'daftar-hadir-pengunjung')
                      ->where('slug', 'not like', 'daftar-hadir-%');
            })
                ->whereDate('booking_date', $dateStr)
                ->where('status', 'approved') // Hanya tampilkan yang sudah disetujui (selain daftar hadir)
                ->get();
            
            $allBookings = collect();

            // Add Blocked Dates
            foreach ($blockedDates as $block) {
                // If it blocks entire day, maybe show "Full Booked"?
                // If session, show session.
                $label = $block->reason ?? 'Booked';
                if ($block->session_time) {
                    $label .= ' (' . $block->session_time . ')';
                } else {
                    $label .= ' (Full Day)';
                }
                
                $allBookings->push([
                    'type' => 'blocked',
                    'label' => $label,
                    'is_full_day' => is_null($block->session_time),
                    'color' => 'red', // Tailwind class suffix
                ]);
            }

            // Add Submissions
            foreach ($submissions as $sub) {
                $session = data_get($sub->data, 'Pilihan Waktu Nobar') ?? data_get($sub->data, 'Pilihan Waktu Kunjungan') ?? '';
                $instansi = data_get($sub->data, 'Instansi') ?? data_get($sub->data, 'Nama Instansi/Sekolah/Universitas') ?? 'Instansi/Umum';
                
                $labelStr = $instansi . ($session ? ' (' . $session . ')' : '');
                
                $allBookings->push([
                    'type' => 'submission',
                    'label' => $labelStr,
                    'session' => $session,
                    'color' => 'emerald',
                    'data' => null // Don't expose original data array to public frontend
                ]);
            }

            $calendar[] = [
                'day' => $day,
                'date' => $dateStr,
                'isToday' => $date->isToday(),
                'bookings' => $allBookings
            ];
        }
        
        return $calendar;
    }

    public function render()
    {
        return view('livewire.front.booking-calendar', [
            'calendarDays' => $this->getDaysProperty(),
            'monthName' => Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->translatedFormat('F Y'),
        ]);
    }
}
