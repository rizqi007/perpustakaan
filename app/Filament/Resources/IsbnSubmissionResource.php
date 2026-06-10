<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IsbnSubmissionResource\Pages;
use App\Models\FormSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IsbnSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Permohonan ISBN';

    protected static ?string $modelLabel = 'Permohonan ISBN';

    protected static ?string $pluralModelLabel = 'Permohonan ISBN';

    protected static ?string $navigationGroup = 'Layanan ISBN';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('form', function ($query) {
            $query->where('slug', 'pengajuan-isbn');
        });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl Masuk')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengirim')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('workflow_status')
                    ->label('Status Proses')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match($state) {
                        'data_diterima'        => '📥 Data Diterima',
                        'verifikasi_kemenag'   => '🔍 Verifikasi Kemenag',
                        'perlu_diperbaiki'     => '⚠️ Perlu Diperbaiki',
                        'menunggu_review'      => '🔄 Sudah Diperbaiki',
                        'proses_pengajuan'     => '📤 Proses Pengajuan',
                        'verifikasi_perpusnas' => '📚 Verifikasi Perpusnas',
                        'isbn_terbit'          => '✅ ISBN Terbit',
                        'penyerahan_buku'      => '📖 Penyerahan Buku',
                        'selesai'              => '🎉 Selesai',
                        default                => ucfirst($state ?? 'data_diterima'),
                    })
                    ->color(fn (?string $state): string => match($state) {
                        'data_diterima'        => 'info',
                        'verifikasi_kemenag'   => 'warning',
                        'perlu_diperbaiki'     => 'danger',
                        'menunggu_review'      => 'info',
                        'proses_pengajuan'     => 'primary',
                        'verifikasi_perpusnas' => 'purple',
                        'isbn_terbit'          => 'success',
                        'penyerahan_buku'      => 'success',
                        'selesai'              => 'success',
                        default                => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('item_data')
                    ->label('Detail Naskah')
                    ->state(function (FormSubmission $record) {
                        $data = $record->data;
                        if (!is_array($data)) return '-';
                        
                        // Robust title matching from user inputs
                        $judul = '-';
                        foreach (['Judul', 'judul', 'Judul Buku', 'judul_buku', 'Nama Buku'] as $key) {
                            if (!empty($data[$key])) {
                                $judul = $data[$key];
                                break;
                            }
                        }
                        
                        // Robust author matching from user inputs
                        $penulis = '-';
                        foreach (['Penulis', 'penulis', 'Kepengarangan', 'Kepengarangan ', 'Pengarang', 'Penyusun'] as $key) {
                            if (!empty($data[$key])) {
                                $penulis = $data[$key];
                                break;
                            }
                        }
                        
                        return "Judul: $judul | Penulis: $penulis";
                    })
                    ->searchable(query: function (Builder $query, string $search) {
                        return $query->where(function ($q) use ($search) {
                            $q->where('data->Judul', 'like', "%{$search}%")
                              ->orWhere('data->judul', 'like', "%{$search}%")
                              ->orWhere('data->Judul Buku', 'like', "%{$search}%")
                              ->orWhere('data->judul_buku', 'like', "%{$search}%")
                              ->orWhere('data->Nama Buku', 'like', "%{$search}%")
                              ->orWhere('data->Penulis', 'like', "%{$search}%")
                              ->orWhere('data->penulis', 'like', "%{$search}%")
                              ->orWhere('data->Kepengarangan', 'like', "%{$search}%")
                              ->orWhere('data->Kepengarangan ', 'like', "%{$search}%")
                              ->orWhere('data->Pengarang', 'like', "%{$search}%")
                              ->orWhere('data->Penyusun', 'like', "%{$search}%");
                        });
                    })
                    ->wrap(),
                Tables\Columns\TextColumn::make('revision_notes')
                    ->label('Catatan Perbaikan')
                    ->placeholder('-')
                    ->color('danger')
                    ->wrap(),
                Tables\Columns\TextColumn::make('isbn_number')
                    ->label('No. ISBN')
                    ->placeholder('-')
                    ->color('success')
                    ->copyable(),
                Tables\Columns\TextColumn::make('file_naskah')
                    ->label('File Naskah')
                    ->state(function (FormSubmission $record) {
                        $data = $record->data;
                        if (!is_array($data)) return 'Tidak ada file';
                        foreach ($data as $key => $value) {
                            if (is_string($value) && Str::startsWith($value, 'form_submissions/')) {
                                return 'Ada File';
                            }
                        }
                        return 'Tidak ada';
                    })
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Ada File' ? 'success' : 'gray')
                    ->url(function (FormSubmission $record): ?string {
                        $data = $record->data;
                        if (!is_array($data)) return null;
                        foreach ($data as $key => $value) {
                            if (is_string($value) && Str::startsWith($value, 'form_submissions/')) {
                                return Storage::url($value);
                            }
                        }
                        return null;
                    })
                    ->openUrlInNewTab(),
                Tables\Columns\IconColumn::make('buku_cetak_diserahkan')
                    ->label('Buku Cetak')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('buku_digital_diserahkan')
                    ->label('Buku Digital')
                    ->boolean()
                    ->sortable(),
            ])
            ->recordClasses(fn (FormSubmission $record): ?string => match ($record->workflow_status) {
                'perlu_diperbaiki' => 'bg-red-50/60 dark:bg-red-950/20 border-l-4 border-l-red-500',
                'isbn_terbit', 'selesai' => 'bg-green-50/30 dark:bg-green-950/10 border-l-4 border-l-green-500',
                default => null,
            })
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('workflow_status')
                    ->label('Status Proses')
                    ->options([
                        'data_diterima'        => '📥 Data Diterima',
                        'verifikasi_kemenag'   => '🔍 Verifikasi Kemenag',
                        'perlu_diperbaiki'     => '⚠️ Perlu Diperbaiki',
                        'menunggu_review'      => '🔄 Sudah Diperbaiki (Menunggu Review)',
                        'proses_pengajuan'     => '📤 Proses Pengajuan',
                        'verifikasi_perpusnas' => '📚 Verifikasi Perpusnas',
                        'isbn_terbit'          => '✅ ISBN Terbit',
                        'penyerahan_buku'      => '📖 Penyerahan Buku',
                        'selesai'              => '🎉 Selesai',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    // ===== Workflow Action =====
                    Tables\Actions\Action::make('ubah_proses')
                        ->label('Ubah Proses')
                        ->icon('heroicon-o-arrow-path')
                        ->color('primary')
                        ->modalSubmitActionLabel('Simpan')
                        ->modalCancelActionLabel('Batal')
                        ->form([
                            Forms\Components\Select::make('workflow_status')
                                ->label('Tahap Proses')
                                ->required()
                                ->options([
                                    'data_diterima'        => '📥 Data Diterima',
                                    'verifikasi_kemenag'   => '🔍 Verifikasi Kemenag',
                                    'perlu_diperbaiki'     => '⚠️ Perlu Diperbaiki',
                                    'menunggu_review'      => '🔄 Sudah Diperbaiki (Menunggu Review)',
                                    'proses_pengajuan'     => '📤 Proses Pengajuan',
                                    'verifikasi_perpusnas' => '📚 Verifikasi Perpusnas',
                                    'isbn_terbit'          => '✅ ISBN Terbit',
                                    'penyerahan_buku'      => '📖 Penyerahan Buku',
                                    'selesai'              => '🎉 Selesai',
                                ])
                                ->live(),
                            Forms\Components\Textarea::make('revision_notes')
                                ->label('Catatan Perbaikan untuk Pengaju')
                                ->helperText('Catatan ini akan tampil di dashboard user.')
                                ->rows(4)
                                ->required()
                                ->visible(fn (Forms\Get $get) => $get('workflow_status') === 'perlu_diperbaiki'),
                            Forms\Components\TextInput::make('isbn_number')
                                ->label('Nomor ISBN yang Diterbitkan')
                                ->placeholder('Contoh: 978-602-xxxx-xx-x')
                                ->required(fn (Forms\Get $get) => in_array($get('workflow_status'), ['isbn_terbit', 'penyerahan_buku', 'selesai']))
                                ->visible(fn (Forms\Get $get) => in_array($get('workflow_status'), ['isbn_terbit', 'penyerahan_buku', 'selesai'])),
                            Forms\Components\Textarea::make('kdt_text')
                                ->label('Teks Katalog Dalam Terbitan (KDT)')
                                ->placeholder("Masukkan teks KDT di sini...")
                                ->rows(5)
                                ->visible(fn (Forms\Get $get) => in_array($get('workflow_status'), ['isbn_terbit', 'penyerahan_buku', 'selesai'])),
                            Forms\Components\FileUpload::make('kdt_file')
                                ->label('File PDF / Gambar KDT')
                                ->directory('kdt_files')
                                ->visible(fn (Forms\Get $get) => in_array($get('workflow_status'), ['isbn_terbit', 'penyerahan_buku', 'selesai'])),
                            Forms\Components\Checkbox::make('buku_cetak_diserahkan')
                                ->label('📖 Buku Cetak Sudah Diserahkan')
                                ->visible(fn (Forms\Get $get) => in_array($get('workflow_status'), ['penyerahan_buku', 'selesai'])),
                            Forms\Components\Checkbox::make('buku_digital_diserahkan')
                                ->label('💾 Buku Digital Sudah Diserahkan')
                                ->visible(fn (Forms\Get $get) => in_array($get('workflow_status'), ['penyerahan_buku', 'selesai'])),
                        ])
                        ->fillForm(fn (FormSubmission $record): array => [
                            'workflow_status' => $record->workflow_status ?? 'data_diterima',
                            'revision_notes'  => $record->revision_notes,
                            'isbn_number'     => $record->isbn_number,
                            'kdt_text'        => $record->kdt_text,
                            'kdt_file'        => $record->kdt_file,
                            'buku_cetak_diserahkan' => (bool) $record->buku_cetak_diserahkan,
                            'buku_digital_diserahkan' => (bool) $record->buku_digital_diserahkan,
                        ])
                        ->action(function (FormSubmission $record, array $data): void {
                            $updateData = [
                                'workflow_status'     => $data['workflow_status'],
                                'workflow_updated_by' => auth()->id(),
                                'workflow_updated_at' => now(),
                            ];

                            $updateData['status'] = match($data['workflow_status']) {
                                'selesai', 'penyerahan_buku', 'isbn_terbit', 'verifikasi_perpusnas', 'proses_pengajuan' => 'approved',
                                'perlu_diperbaiki' => 'rejected',
                                'menunggu_review' => 'pending',
                                default => 'pending',
                            };

                            if ($data['workflow_status'] === 'perlu_diperbaiki') {
                                $updateData['revision_notes'] = $data['revision_notes'];
                            } else {
                                $updateData['revision_notes'] = null;
                            }

                            if (in_array($data['workflow_status'], ['isbn_terbit', 'penyerahan_buku', 'selesai'])) {
                                $updateData['isbn_number'] = $data['isbn_number'] ?? null;
                                $updateData['kdt_text'] = $data['kdt_text'] ?? null;
                                $updateData['kdt_file'] = $data['kdt_file'] ?? null;
                            }

                            if (in_array($data['workflow_status'], ['penyerahan_buku', 'selesai'])) {
                                $updateData['buku_cetak_diserahkan'] = $data['buku_cetak_diserahkan'] ?? false;
                                $updateData['buku_digital_diserahkan'] = $data['buku_digital_diserahkan'] ?? false;
                            } else {
                                $updateData['buku_cetak_diserahkan'] = false;
                                $updateData['buku_digital_diserahkan'] = false;
                            }

                            $record->update($updateData);

                            \Filament\Notifications\Notification::make()
                                ->title('Status proses berhasil diperbarui')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\ViewAction::make()
                        ->label('Lihat Detail')
                        ->icon('heroicon-o-eye'),
                ])
                ->icon('heroicon-m-ellipsis-vertical')
                ->tooltip('Aksi'),
            ])

            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
                    ->exports([
                        \pxlrbt\FilamentExcel\Exports\ExcelExport::make()
                            ->fromTable()
                            ->withFilename(fn ($resource) => $resource::getModelLabel() . '-' . date('Y-m-d'))
                            ->withColumns([
                                \pxlrbt\FilamentExcel\Columns\Column::make('created_at')->heading('Tanggal Masuk'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('user.name')->heading('Pengirim'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('workflow_status')->heading('Status Proses'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('data.Judul')->heading('Judul Buku'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('data.Penulis')->heading('Penulis'),
                            ])
                    ])
                    ->label('Export Data (Excel/CSV)'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make()
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Status Permohonan')
                     ->schema([
                        Infolists\Components\TextEntry::make('workflow_status')
                            ->label('Status Proses')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): string => match($state) {
                                'data_diterima'        => '📥 Data Diterima',
                                'verifikasi_kemenag'   => '🔍 Verifikasi Kemenag',
                                'perlu_diperbaiki'     => '⚠️ Perlu Diperbaiki',
                                'menunggu_review'      => '🔄 Sudah Diperbaiki',
                                'proses_pengajuan'     => '📤 Proses Pengajuan',
                                'verifikasi_perpusnas' => '📚 Verifikasi Perpusnas',
                                'isbn_terbit'          => '✅ ISBN Terbit',
                                'penyerahan_buku'      => '📖 Penyerahan Buku',
                                'selesai'              => '🎉 Selesai',
                                default                => ucfirst($state ?? '-'),
                            })
                            ->color(fn (?string $state): string => match($state) {
                                'perlu_diperbaiki' => 'danger',
                                'selesai', 'isbn_terbit', 'penyerahan_buku' => 'success',
                                default => 'warning',
                            }),
                        Infolists\Components\TextEntry::make('revision_notes')
                            ->label('Catatan Perbaikan')
                            ->visible(fn (FormSubmission $record) => !empty($record->revision_notes))
                            ->color('danger'),
                        Infolists\Components\TextEntry::make('isbn_number')
                            ->label('Nomor ISBN')
                            ->visible(fn (FormSubmission $record) => !empty($record->isbn_number))
                            ->copyable()
                            ->color('success'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Masuk')
                            ->dateTime('d M Y, H:i:s'),
                        Infolists\Components\IconEntry::make('buku_cetak_diserahkan')
                            ->label('Buku Cetak Diserahkan')
                            ->boolean()
                            ->visible(fn (FormSubmission $record) => in_array($record->workflow_status, ['penyerahan_buku', 'selesai'])),
                        Infolists\Components\IconEntry::make('buku_digital_diserahkan')
                            ->label('Buku Digital Diserahkan')
                            ->boolean()
                            ->visible(fn (FormSubmission $record) => in_array($record->workflow_status, ['penyerahan_buku', 'selesai'])),
                        Infolists\Components\TextEntry::make('kdt_text')
                            ->label('Teks KDT')
                            ->visible(fn (FormSubmission $record) => !empty($record->kdt_text))
                            ->fontFamily(\Filament\Support\Enums\FontFamily::Mono)
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('kdt_file')
                            ->label('File KDT')
                            ->visible(fn (FormSubmission $record) => !empty($record->kdt_file))
                            ->url(fn (FormSubmission $record) => Storage::url($record->kdt_file))
                            ->openUrlInNewTab()
                            ->color('primary'),
                     ])->columns(2),

                Infolists\Components\Section::make('Data Pengajuan')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Infolists\Components\ViewEntry::make('data')
                            ->view('filament.infolists.data-table')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIsbnSubmissions::route('/'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
}
