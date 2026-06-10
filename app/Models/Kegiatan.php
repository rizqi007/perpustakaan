<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'deskripsi',
        'cover_image',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'narasumber',
        'file_paparan',
        'file_artikel',
        'link_rekaman',
        'link_dokumentasi',
        'galeri',
        'jumlah_peserta',
        'is_published',
    ];

    protected $casts = [
        'narasumber' => 'array',
        'galeri' => 'array',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Kegiatan $kegiatan) {
            if (empty($kegiatan->slug)) {
                $kegiatan->slug = Str::slug($kegiatan->judul);
            }
        });
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'seminar' => 'Seminar',
            'bedah_buku' => 'Bedah Buku',
            'workshop' => 'Workshop',
            'diskusi' => 'Diskusi',
            'pameran' => 'Pameran',
            'lainnya' => 'Lainnya',
            default => $this->kategori,
        };
    }
}
