<?php

namespace App\Filament\Widgets;

use App\Models\FormSubmission;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class FormSubmissionChart extends ChartWidget
{
    protected static ?string $heading = 'Isian Formulir per Bulan';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M Y');
            $data[] = FormSubmission::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Isian Formulir',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(59, 130, 246, 0.6)',
                        'rgba(59, 130, 246, 0.5)',
                        'rgba(59, 130, 246, 0.6)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(59, 130, 246, 0.5)',
                        'rgba(59, 130, 246, 0.6)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(59, 130, 246, 0.5)',
                        'rgba(59, 130, 246, 0.6)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(59, 130, 246, 0.8)',
                    ],
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
