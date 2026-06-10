<?php

namespace App\Filament\Widgets;

use App\Models\IsbnSubmission;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class IsbnSubmissionChart extends ChartWidget
{
    protected static ?string $heading = 'Pengajuan ISBN per Bulan';
    protected static ?int $sort = 1;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M Y');
            $data[] = IsbnSubmission::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengajuan ISBN',
                    'data' => $data,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
