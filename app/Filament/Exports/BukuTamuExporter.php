<?php

namespace App\Filament\Exports;

use App\Models\BukuTamu;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BukuTamuExporter extends Exporter
{
    protected static ?string $model = BukuTamu::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama')->label('Nama Lengkap'),
            ExportColumn::make('institusi')->label('Institusi/Sekolah/Universitas'),
            ExportColumn::make('created_at')->label('Tanggal Kunjungan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your buku tamu export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
