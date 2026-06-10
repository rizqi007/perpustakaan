<?php

namespace App\Filament\Resources\AnggotaResource\Pages;

use App\Filament\Resources\AnggotaResource;
use App\Services\SlimsSyncService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListAnggotas extends ListRecords
{
    protected static string $resource = AnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('import_slims')
                ->label('Tarik Data dari SLiMS')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Tarik Data dari SLiMS')
                ->modalDescription('Apakah Anda yakin ingin menarik semua data anggota dari database SLiMS? Pendaftaran anggota baru akan diimpor dan anggota lama akan diperbarui berdasarkan NIP. Data anggota baru otomatis disetujui.')
                ->modalSubmitActionLabel('Ya, Tarik Data')
                ->modalCancelActionLabel('Batal')
                ->action(function () {
                    try {
                        $result = SlimsSyncService::importFromSlims();

                        Notification::make()
                            ->title('Sinkronisasi Selesai')
                            ->body("Berhasil mengimpor {$result['imported']} anggota baru dan memperbarui {$result['updated']} anggota.")
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Sinkronisasi Gagal')
                            ->body($e->getMessage())
                            ->danger()
                            ->persistent()
                            ->send();
                    }
                }),
        ];
    }
}

