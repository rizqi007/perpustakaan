<?php

namespace App\Filament\Resources\BukuTamuResource\Pages;

use App\Filament\Resources\BukuTamuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBukuTamus extends ListRecords
{
    protected static string $resource = BukuTamuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \pxlrbt\FilamentExcel\Actions\Pages\ExportAction::make()
                ->exports([
                    \pxlrbt\FilamentExcel\Exports\ExcelExport::make('csv')
                        ->fromTable()
                        ->withFilename('Data_Pengunjung_' . date('Ymd'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                        ->label('Export CSV'),
                    \pxlrbt\FilamentExcel\Exports\ExcelExport::make('pdf')
                        ->fromTable()
                        ->withFilename('Data_Pengunjung_' . date('Ymd'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::DOMPDF)
                        ->label('Export PDF'),
                ])
                ->label('Export Data')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\VisitorChart::class,
        ];
    }
}
