<?php

namespace App\Filament\Resources\FormResource\RelationManagers;

use App\Exports\FormSubmissionExport;
use App\Models\Form;
use Filament\Forms;
use Filament\Forms\Form as FilamentForm;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';

    protected static ?string $title = 'Data Kehadiran';

    public function form(FilamentForm $form): FilamentForm
    {
        return $form
            ->schema([
                Forms\Components\KeyValue::make('data')
                    ->label('Data Isian')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        /** @var Form $ownerRecord */
        $ownerRecord = $this->getOwnerRecord();
        $fields = collect($ownerRecord->fields ?? []);

        // Build dynamic columns from form field definitions
        $dynamicColumns = $fields
            ->filter(fn ($field) => strtolower($field['label'] ?? '') !== 'kegiatan')
            ->map(function ($field) {
                return Tables\Columns\TextColumn::make('data.' . $field['label'])
                    ->label($field['label'])
                    ->default('-')
                    ->searchable()
                    ->wrap()
                    ->limit(60);
            })
            ->values()
            ->toArray();

        return $table
            ->recordTitleAttribute('id')
            ->defaultSort('created_at', 'desc')
            ->columns(array_merge(
                [
                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Tgl Hadir')
                        ->dateTime('d M Y, H:i')
                        ->sortable()
                        ->width('140px'),
                ],
                $dynamicColumns,
            ))
            ->filters([
                Tables\Filters\Filter::make('today')
                    ->label('Hari Ini')
                    ->query(fn (Builder $query) => $query->whereDate('created_at', today())),
                Tables\Filters\Filter::make('this_week')
                    ->label('Minggu Ini')
                    ->query(fn (Builder $query) => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
            ])
            ->headerActions([
                // Export Excel
                Tables\Actions\Action::make('export_excel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-table-cells')
                    ->color('success')
                    ->action(function () use ($ownerRecord) {
                        $submissions = $ownerRecord->submissions()->orderBy('created_at')->get();
                        $filename = 'daftar-hadir-' . $ownerRecord->slug . '-' . now()->format('Ymd_His') . '.xlsx';
                        return Excel::download(new FormSubmissionExport($ownerRecord, $submissions), $filename);
                    }),

                // Export PDF
                Tables\Actions\Action::make('export_pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->action(function () use ($ownerRecord) {
                        $submissions = $ownerRecord->submissions()->orderBy('created_at')->get();

                        // Build field labels and extra keys
                        $fieldLabels = collect($ownerRecord->fields ?? [])->pluck('label')->toArray();
                        $extraKeys = $submissions->flatMap(fn ($s) => array_keys($s->data ?? []))
                            ->unique()
                            ->diff($fieldLabels)
                            ->values()
                            ->toArray();

                        $html = view('exports.daftar-hadir-pdf', compact(
                            'ownerRecord',
                            'submissions',
                            'fieldLabels',
                            'extraKeys',
                        ))->with('form', $ownerRecord)->render();

                        $dompdf = new \Dompdf\Dompdf();
                        $dompdf->set_option('isHtml5ParserEnabled', true);
                        $dompdf->set_option('isRemoteEnabled', true);
                        $dompdf->set_option('defaultFont', 'dejavu sans');
                        $dompdf->setPaper('A4', 'landscape');
                        $dompdf->loadHtml($html, 'UTF-8');
                        $dompdf->render();

                        $filename = 'daftar-hadir-' . $ownerRecord->slug . '-' . now()->format('Ymd_His') . '.pdf';

                        return response()->streamDownload(
                            fn () => print($dompdf->output()),
                            $filename,
                            ['Content-Type' => 'application/pdf']
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('download_certificate')
                    ->label('Sertifikat')
                    ->icon('heroicon-o-academic-cap')
                    ->color('success')
                    ->action(function ($record) {
                        $form = $record->form;
                        $certificate = $form->certificate;
                        
                        if (!$certificate) {
                            Notification::make()
                                ->title('Sertifikat Belum Dikonfigurasi')
                                ->body('Silakan atur desain sertifikat untuk acara ini terlebih dahulu di menu Desain Sertifikat.')
                                ->warning()
                                ->send();
                            return;
                        }

                        // Retrieve the name field value
                        $nameField = $certificate->name_field ?? 'Nama';
                        $name = $record->data[$nameField] ?? $record->user?->name ?? '-';

                        try {
                            // Render the certificate PDF
                            $html = view('exports.certificate-pdf', [
                                'form' => $form,
                                'certificate' => $certificate,
                                'name' => $name,
                                'submission' => $record,
                            ])->render();

                            $dompdf = new \Dompdf\Dompdf();
                            $dompdf->set_option('isHtml5ParserEnabled', true);
                            $dompdf->set_option('isRemoteEnabled', true);
                            $dompdf->set_option('defaultFont', 'dejavu sans');
                            $dompdf->setPaper('A4', 'landscape');
                            $dompdf->loadHtml($html, 'UTF-8');
                            $dompdf->render();

                            $filename = 'sertifikat-' . \Illuminate\Support\Str::slug($name) . '-' . $form->slug . '.pdf';

                            return response()->streamDownload(
                                fn () => print($dompdf->output()),
                                $filename,
                                ['Content-Type' => 'application/pdf']
                            );
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal Membuat Sertifikat')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    // Bulk export selected rows to Excel
                    Tables\Actions\BulkAction::make('bulk_export_excel')
                        ->label('Export Dipilih (Excel)')
                        ->icon('heroicon-o-table-cells')
                        ->color('success')
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) use ($ownerRecord) {
                            $filename = 'daftar-hadir-pilihan-' . now()->format('Ymd_His') . '.xlsx';
                            return Excel::download(
                                new FormSubmissionExport($ownerRecord, $records),
                                $filename
                            );
                        }),
                ]),
            ]);
    }
}
