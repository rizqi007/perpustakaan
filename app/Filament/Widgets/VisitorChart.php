<?php

namespace App\Filament\Widgets;

use App\Models\BukuTamu;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class VisitorChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pengunjung (7 Hari Terakhir)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->translatedFormat('d M');
            $data[] = BukuTamu::whereDate('created_at', $date->toDateString())->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pengunjung',
                    'data' => $data,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'borderColor' => '#10b981',
                    'fill' => 'start',
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
