<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TempatSampahResource\Pages;
use App\Models\TrashBin;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TempatSampahResource extends Resource
{
    protected static ?string $model = TrashBin::class;

    protected static ?string $navigationIcon = 'heroicon-o-trash';

    protected static ?string $navigationLabel = 'Tempat Sampah';

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Tempat Sampah';

    protected static ?string $pluralModelLabel = 'Tempat Sampah';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model_type')
                    ->label('Tipe Data')
                    ->formatStateUsing(fn ($state) => match($state) {
                        \App\Models\Berita::class => 'Berita',
                        \App\Models\Anggota::class => 'Anggota Perpustakaan',
                        \App\Models\KatalogBuku::class => 'Katalog Buku',
                        \App\Models\KlipingDigital::class => 'Kliping Digital',
                        \App\Models\Resensi::class => 'Resensi Buku',
                        \App\Models\Testimoni::class => 'Testimoni',
                        \App\Models\Layanan::class => 'Layanan',
                        \App\Models\Banner::class => 'Banner Utama',
                        \App\Models\NavigationMenu::class => 'Navigasi Situs',
                        \App\Models\FormSubmission::class => 'Isian Formulir',
                        \App\Models\IsbnSubmission::class => 'Pengajuan ISBN',
                        default => class_basename($state),
                    })
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        \App\Models\Berita::class => 'info',
                        \App\Models\Anggota::class => 'success',
                        \App\Models\KatalogBuku::class => 'warning',
                        \App\Models\FormSubmission::class => 'gray',
                        \App\Models\IsbnSubmission::class => 'primary',
                        default => 'danger',
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('label')
                    ->label('Nama / Judul Item')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Dihapus')
                    ->dateTime('d M Y H:i', 'Asia/Jakarta')
                    ->sortable(),

                Tables\Columns\TextColumn::make('deleted_by')
                    ->label('Dihapus Oleh')
                    ->badge()
                    ->color('gray')
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('restore')
                    ->label('Pulihkan')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Pulihkan Data')
                    ->modalDescription('Apakah Anda yakin ingin memulihkan data ini kembali ke asalnya?')
                    ->action(function (TrashBin $record) {
                        $modelType = $record->model_type;
                        $payload = $record->payload;

                        // Instantiate model and fill raw attributes
                        $model = new $modelType;
                        $model->forceFill($payload);
                        $model->save();

                        // Delete from trash log
                        $record->delete();

                        \Filament\Notifications\Notification::make()
                            ->title('Data berhasil dipulihkan ke asalnya')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('forceDelete')
                    ->label('Hapus Permanen')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Permanen')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data ini secara permanen? Tindakan ini tidak dapat dibatalkan.')
                    ->action(function (TrashBin $record) {
                        $record->delete();

                        \Filament\Notifications\Notification::make()
                            ->title('Data berhasil dihapus secara permanen')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('restoreSelected')
                        ->label('Pulihkan Terpilih')
                        ->icon('heroicon-o-arrow-path')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (\Illuminate\Support\Collection $records) {
                            foreach ($records as $record) {
                                $modelType = $record->model_type;
                                $payload = $record->payload;

                                $model = new $modelType;
                                $model->forceFill($payload);
                                $model->save();

                                $record->delete();
                            }

                            \Filament\Notifications\Notification::make()
                                ->title('Semua data terpilih berhasil dipulihkan')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Permanen Terpilih')
                        ->modalHeading('Hapus Permanen Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus secara permanen semua data terpilih? Tindakan ini tidak dapat dibatalkan.'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTempatSampahs::route('/'),
        ];
    }
}
