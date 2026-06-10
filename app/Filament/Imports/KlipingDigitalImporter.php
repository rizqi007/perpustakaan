<?php

namespace App\Filament\Imports;

use App\Models\KlipingDigital;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class KlipingDigitalImporter extends Importer
{
    protected static ?string $model = KlipingDigital::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('title')
                ->label('Judul Artikel')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('author')
                ->label('Penulis')
                ->rules(['max:255']),
            ImportColumn::make('source')
                ->label('Media')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('topic')
                ->label('Rubrik')
                ->rules(['max:255']),
            ImportColumn::make('page_number')
                ->label('Halaman'),
            ImportColumn::make('tanggal')
                ->label('Tanggal')
                ->numeric()
                ->rules(['required']),
            ImportColumn::make('bulan')
                ->label('Bulan')
                ->rules(['required']),
            ImportColumn::make('tahun')
                ->label('Tahun')
                ->numeric()
                ->rules(['required']),
        ];
    }

    public function resolveRecord(): ?KlipingDigital
    {
        return new KlipingDigital();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your kliping digital import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
