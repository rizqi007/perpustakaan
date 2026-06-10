<?php

namespace App\Filament\Widgets;

use App\Models\Form;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Filament\Widgets\Widget;

class FormCalendarWidget extends Widget
{
    protected static string $view = 'filament.widgets.form-calendar-widget';

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return false;
    }

    public $currentMonth;
    public $currentYear;
    public $days = [];
    public $forms = [];

    public function mount()
    {
        $now = Carbon::now();
        $this->currentMonth = $now->month;
        $this->currentYear = $now->year;
        $this->loadCalendar();
    }

    public function loadCalendar()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        
        // Calendar Grid Logic
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        
        // Start from the beginning of the week (Monday)
        $startGrid = $startOfMonth->copy()->startOfWeek(CarbonInterface::MONDAY);
        $endGrid = $endOfMonth->copy()->endOfWeek(CarbonInterface::SUNDAY);

        $this->days = [];
        $current = $startGrid->copy();

        while ($current->lte($endGrid)) {
            $this->days[] = [
                'date' => $current->format('Y-m-d'),
                'day' => $current->day,
                'isCurrentMonth' => $current->month === $this->currentMonth,
                'isToday' => $current->isToday(),
            ];
            $current->addDay();
        }

        // Fetch Forms for this month
        // Form spans if start_date <= endOfGrid AND (end_date >= startOfGrid OR end_date is null)
        // Adjust query logic:
        $this->forms = Form::where('is_active', true)
            ->with(['submissions.user']) // Eager load submissions and users
            ->where(function ($query) use ($startGrid, $endGrid) {
                $query->whereBetween('start_date', [$startGrid->format('Y-m-d'), $endGrid->format('Y-m-d')])
                      ->orWhereBetween('end_date', [$startGrid->format('Y-m-d'), $endGrid->format('Y-m-d')])
                      ->orWhere(function ($q) use ($startGrid, $endGrid) {
                          $q->where('start_date', '<=', $startGrid->format('Y-m-d'))
                            ->where('end_date', '>=', $endGrid->format('Y-m-d'));
                      });
            })
            ->get()
            ->map(function ($form) {
                $names = [];
                // Extract participant names
                foreach ($form->submissions as $submission) {
                    $name = 'Peserta';
                    
                    if ($form->participant_label && isset($submission->data[$form->participant_label])) {
                        $name = $submission->data[$form->participant_label];
                    } elseif ($submission->user) {
                        $name = $submission->user->name;
                    }
                    
                    $names[] = $name;
                }

                // Calculate total registered count (sum of quota_count_label if set, else count of submissions)
                $registeredCount = $form->submissions->sum(function($submission) use ($form) {
                    return (int) ($form->quota_count_label && isset($submission->data[$form->quota_count_label]) 
                        ? $submission->data[$form->quota_count_label] 
                        : 1);
                });

                return [
                    'id' => $form->id,
                    'title' => $form->title,
                    'start' => $form->start_date ? $form->start_date->format('Y-m-d') : null,
                    'end' => $form->end_date ? $form->end_date->format('Y-m-d') : ($form->start_date ? $form->start_date->format('Y-m-d') : null),
                    'quota' => $form->max_quota,
                    'registered' => $registeredCount,
                    'isFull' => $form->max_quota && $registeredCount >= $form->max_quota,
                    'participants' => $names,
                ];
            });
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadCalendar();
    }

    public function prevMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadCalendar();
    }
}
