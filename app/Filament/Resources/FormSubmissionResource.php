<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormSubmissionResource\Pages;
use App\Models\FormSubmission;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Maatwebsite\Excel\Excel;

class FormSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationLabel = 'Penerimaan Formulir';

    protected static ?string $modelLabel = 'Penerimaan Formulir';

    protected static ?string $pluralModelLabel = 'Penerimaan Formulir';

    protected static ?string $navigationGroup = 'Formulir';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['form'])->whereHas('form', function ($query) {
            $query->where('slug', '!=', 'pengajuan-isbn');
        });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl Masuk')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengirim')
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('form.title')
                    ->label('Formulir')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                    
                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Tgl Booking')
                    ->date('d M Y')
                    ->icon('heroicon-m-calendar')
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('session_info')
                    ->label('Sesi / Waktu')
                    ->state(function (FormSubmission $record) {
                        $sessionLabel = $record->form->time_slot_label;
                        if (!$sessionLabel || !isset($record->data[$sessionLabel])) {
                            return null;
                        }
                        return (string) $record->data[$sessionLabel]; 
                    })
                    ->icon('heroicon-m-clock')
                    ->placeholder('-')
                    ->wrap()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('form_id')
                    ->label('Formulir')
                    ->relationship('form', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('approve')
                        ->label('Setujui')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Setujui Pengajuan')
                        ->modalDescription('Apakah Anda yakin ingin menyetujui pengajuan ini? Tiket akan otomatis dibuat.')
                        ->action(function (FormSubmission $record, \App\Services\TicketService $ticketService) {
                            // Update status
                            $record->update(['status' => 'approved']);
                            
                            try {
                                // Generate Ticket (returns relative path)
                                $ticketPath = $ticketService->generateAndReturnPath($record);
                                
                                // Save Ticket Path
                                $record->update(['ticket_path' => $ticketPath]);
                                
                                \Filament\Notifications\Notification::make()
                                    ->title('Berhasil disetujui')
                                    ->body('Tiket berhasil dibuat.')
                                    ->success()
                                    ->send();
                                    
                            } catch (\Exception $e) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Gagal membuat tiket')
                                    ->body($e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->visible(fn (FormSubmission $record) => $record->status === 'pending'),

                    Tables\Actions\Action::make('reject')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (FormSubmission $record) {
                            $record->update(['status' => 'rejected']);
                            \Filament\Notifications\Notification::make()
                                ->title('Pengajuan ditolak')
                                ->success()
                                ->send();
                        })
                        ->visible(fn (FormSubmission $record) => $record->status === 'pending'),

                    Tables\Actions\ViewAction::make()
                        ->label('Lihat')
                        ->icon('heroicon-o-eye'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus'),
                ])
                ->icon('heroicon-m-ellipsis-vertical')
                ->tooltip('Aksi'),
            ])
            ->headerActions([
                ExportAction::make('export_csv')
                    ->label('Export CSV')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(fn () => 'Penerimaan-Formulir-' . date('Y-m-d') . '.csv')
                            ->withWriterType(Excel::CSV)
                            ->withColumns([
                                \pxlrbt\FilamentExcel\Columns\Column::make('created_at')->heading('Tgl Masuk'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('booking_date')->heading('Tgl Booking'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('user.name')->heading('Pengirim'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('form.title')->heading('Formulir'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('status')->heading('Status'),
                            ])
                    ]),
                ExportAction::make('export_pdf')
                    ->label('Export PDF')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(fn () => 'Penerimaan-Formulir-' . date('Y-m-d') . '.pdf')
                            ->withWriterType(Excel::DOMPDF)
                            ->withColumns([
                                \pxlrbt\FilamentExcel\Columns\Column::make('created_at')->heading('Tgl Masuk'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('booking_date')->heading('Tgl Booking'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('user.name')->heading('Pengirim'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('form.title')->heading('Formulir'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('status')->heading('Status'),
                            ])
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make('export_csv')
                        ->label('Export CSV')
                        ->exports([
                            ExcelExport::make()
                                ->fromTable()
                                ->withFilename(fn () => 'Penerimaan-Formulir-' . date('Y-m-d') . '.csv')
                                ->withWriterType(Excel::CSV)
                                ->withColumns([
                                    \pxlrbt\FilamentExcel\Columns\Column::make('created_at')->heading('Tgl Masuk'),
                                    \pxlrbt\FilamentExcel\Columns\Column::make('booking_date')->heading('Tgl Booking'),
                                    \pxlrbt\FilamentExcel\Columns\Column::make('user.name')->heading('Pengirim'),
                                    \pxlrbt\FilamentExcel\Columns\Column::make('form.title')->heading('Formulir'),
                                    \pxlrbt\FilamentExcel\Columns\Column::make('status')->heading('Status'),
                                ])
                        ]),
                    ExportBulkAction::make('export_pdf')
                        ->label('Export PDF')
                        ->exports([
                            ExcelExport::make()
                                ->fromTable()
                                ->withFilename(fn () => 'Penerimaan-Formulir-' . date('Y-m-d') . '.pdf')
                                ->withWriterType(Excel::DOMPDF)
                                ->withColumns([
                                    \pxlrbt\FilamentExcel\Columns\Column::make('created_at')->heading('Tgl Masuk'),
                                    \pxlrbt\FilamentExcel\Columns\Column::make('booking_date')->heading('Tgl Booking'),
                                    \pxlrbt\FilamentExcel\Columns\Column::make('user.name')->heading('Pengirim'),
                                    \pxlrbt\FilamentExcel\Columns\Column::make('form.title')->heading('Formulir'),
                                    \pxlrbt\FilamentExcel\Columns\Column::make('status')->heading('Status'),
                                ])
                        ]),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Status Pengajuan')
                     ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('booking_date')
                            ->label('Tanggal Booking')
                            ->date('d M Y'),
                     ])->columns(2),

                Infolists\Components\Section::make('Informasi Formulir')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Infolists\Components\TextEntry::make('form.title')
                            ->label('Nama Formulir')
                            ->badge()
                            ->color('success'),
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Pengirim'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Masuk')
                            ->dateTime('d M Y, H:i:s'),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Data yang Dikirim')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema(function (FormSubmission $record): array {
                        $entries = [];
                        if (is_array($record->data)) {
                            foreach ($record->data as $key => $value) {
                                $entries[] = Infolists\Components\TextEntry::make('data_' . $key)
                                    ->label($key)
                                    ->state($value ?: '-')
                                    ->columnSpanFull();
                            }
                        }
                        return $entries;
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormSubmissions::route('/'),
            // 'view' => Pages\ViewFormSubmission::route('/{record}'), // View modal is enough usually
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
}
