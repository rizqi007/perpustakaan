<?php

namespace App\Filament\Widgets;

use App\Models\FormSubmission;
use App\Models\IsbnSubmission;
use App\Models\Visitor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $todayVisitors = Visitor::where('visit_date', today())->count();
        $totalVisitors = Visitor::count();
        $totalIsbn = IsbnSubmission::count();
        $pendingIsbn = IsbnSubmission::where('status', 'pending')->count();
        $totalFormSubmissions = FormSubmission::count();

        // Build trend description for visitors
        $yesterdayVisitors = Visitor::where('visit_date', today()->subDay())->count();
        $visitorTrend = $todayVisitors >= $yesterdayVisitors ? 'increase' : 'decrease';
        $visitorColor = $todayVisitors >= $yesterdayVisitors ? 'success' : 'danger';

        return [
            Stat::make('Pengunjung Hari Ini', $todayVisitors)
                ->description($totalVisitors . ' total pengunjung')
                ->descriptionIcon('heroicon-m-eye')
                ->color($visitorColor)
                ->chart($this->getVisitorChartData()),

            Stat::make('Pengajuan ISBN', $totalIsbn)
                ->description($pendingIsbn . ' menunggu review')
                ->descriptionIcon('heroicon-m-document-text')
                ->color($pendingIsbn > 0 ? 'warning' : 'success')
                ->chart($this->getIsbnChartData()),

            Stat::make('Isian Formulir', $totalFormSubmissions)
                ->description('Total formulir terisi')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info')
                ->chart($this->getFormChartData()),

            Stat::make('ISBN Tertunda', $pendingIsbn)
                ->description('Perlu ditinjau')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingIsbn > 0 ? 'danger' : 'success'),
        ];
    }

    private function getVisitorChartData(): array
    {
        return Visitor::query()
            ->selectRaw('DATE(visit_date) as date, COUNT(*) as count')
            ->where('visit_date', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray() ?: [0];
    }

    private function getIsbnChartData(): array
    {
        return IsbnSubmission::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray() ?: [0];
    }

    private function getFormChartData(): array
    {
        return FormSubmission::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray() ?: [0];
    }
}
