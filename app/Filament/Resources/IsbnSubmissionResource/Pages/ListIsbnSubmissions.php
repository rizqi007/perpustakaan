<?php

namespace App\Filament\Resources\IsbnSubmissionResource\Pages;

use App\Filament\Resources\IsbnSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListIsbnSubmissions extends ListRecords
{
    protected static string $resource = IsbnSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(), 
        ];
    }
    private function getIsbnCount(string|array $status = null): int
    {
        $query = \App\Models\FormSubmission::whereHas('form', function ($q) {
            $q->where('slug', 'pengajuan-isbn');
        });

        if ($status) {
            if (is_array($status)) {
                $query->whereIn('workflow_status', $status);
            } else {
                $query->where('workflow_status', $status);
            }
        }

        return $query->count();
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->label('Semua')
                ->badge(fn () => $this->getIsbnCount() ?: null),
            
            'verifikasi_kemenag' => Tab::make('Verifikasi Kemenag')
                ->label('🔍 Verifikasi Kemenag')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('workflow_status', ['data_diterima', 'verifikasi_kemenag', 'perlu_diperbaiki', 'menunggu_review']))
                ->badge(fn () => $this->getIsbnCount(['data_diterima', 'verifikasi_kemenag', 'perlu_diperbaiki', 'menunggu_review']) ?: null)
                ->badgeColor('warning'),

            'proses_perpusnas' => Tab::make('Proses Perpusnas')
                ->label('📚 Proses Perpusnas')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('workflow_status', ['proses_pengajuan', 'verifikasi_perpusnas', 'isbn_terbit']))
                ->badge(fn () => $this->getIsbnCount(['proses_pengajuan', 'verifikasi_perpusnas', 'isbn_terbit']) ?: null)
                ->badgeColor('info'),

            'penyerahan_buku' => Tab::make('Penyerahan Buku')
                ->label('📖 Penyerahan Buku')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('workflow_status', 'penyerahan_buku'))
                ->badge(fn () => $this->getIsbnCount('penyerahan_buku') ?: null)
                ->badgeColor('primary'),

            'selesai' => Tab::make('Selesai')
                ->label('🎉 Selesai')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('workflow_status', 'selesai'))
                ->badge(fn () => $this->getIsbnCount('selesai') ?: null)
                ->badgeColor('success'),
        ];
    }}
