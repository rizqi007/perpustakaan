<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Form;
use App\Models\FormSubmission;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class FormIndex extends Component
{
    public $month;
    public $year;
    public $selectedDate;

    public function mount()
    {
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->addMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }

    public function prevMonth()
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->subMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }

    public function render()
    {
        // Get all active forms to list
        $forms = Form::where('is_active', true)
            ->where('slug', '!=', 'daftar-hadir-pengunjung')
            ->where('slug', 'not like', 'daftar-hadir-%')
            ->get();

        // Calculate Calendar Data for ALL forms combined? Or just general availability?
        // User screenshot implies "Jadwal Nobar & Diskusi". This suggests the calendar might be specific to ONE form category or all?
        // Let's assume it aggregates all "Events" on the calendar.
        
        $startGrid = Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth()->startOfWeek(CarbonInterface::MONDAY);
        $endGrid = Carbon::createFromDate($this->year, $this->month, 1)->endOfMonth()->endOfWeek(CarbonInterface::SUNDAY);

        $calendarEvents = [];
        
        // Loop through forms and mapping their dates to calendar
        foreach ($forms as $form) {
            // Only map forms that have dates
            if ($form->start_date) {
                // Determine range
                $start = $form->start_date;
                $end = $form->end_date ?? $start;
                
                // We only care if it overlaps with current view
                // Simplified: iterate through days of the month and check availability
            }
        }
        
        return view('livewire.front.form-index', [
            'forms' => $forms,
            'currentMonthName' => Carbon::createFromDate($this->year, $this->month, 1)->translatedFormat('F Y'),
            'calendarData' => $this->getCalendarData($forms, $startGrid, $endGrid),
        ])->layout('layouts.public');
    }

    private function getCalendarData($forms, $start, $end)
    {
        $data = [];
        $curr = $start->copy();

        while ($curr <= $end) {
            $dateStr = $curr->format('Y-m-d');
            $dayEvents = [];

            foreach ($forms as $form) {
                // Check if form is active on this day
                if ($form->start_date && $curr->between($form->start_date, $form->end_date ?? $form->start_date)) {
                    
                    // Check Quota
                    $usage = 0;
                    if ($form->max_quota) {
                        $usage = $form->submissions()
                            ->where('booking_date', $dateStr)
                            ->get()
                            ->sum(function($sub) use ($form) {
                                return (int) ($form->quota_count_label && isset($sub->data[$form->quota_count_label]) 
                                    ? $sub->data[$form->quota_count_label] 
                                    : 1);
                            });
                    }

                    $isFull = $form->max_quota && $usage >= $form->max_quota;

                    $dayEvents[] = [
                        'id' => $form->id,
                        'title' => $form->title,
                        'class' => $isFull ? 'bg-red-500' : 'bg-emerald-500',
                        'isFull' => $isFull,
                    ];
                }
            }

            $data[] = [
                'date' => $curr->copy(),
                'events' => $dayEvents,
                'isCurrentMonth' => $curr->month == $this->month,
            ];

            $curr->addDay();
        }

        return $data;
    }
}
