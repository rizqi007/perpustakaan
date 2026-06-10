<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewFormSubmissionNotification;
use App\Traits\Trashable;

class FormSubmission extends Model
{
    use Trashable;
    protected static function booted(): void
    {
        static::created(function (FormSubmission $submission) {
            $admins = \App\Models\User::whereIn('role', ['admin', 'superadmin'])->get();
            /** @var \App\Models\User $admin */
            foreach ($admins as $admin) {
                $admin->notify(new NewFormSubmissionNotification($submission));
            }
        });
    }
    protected $fillable = [
        'form_id', 'user_id', 'data', 'status', 'booking_date', 'ticket_path',
        'workflow_status', 'revision_notes', 'isbn_number', 'kdt_text', 'kdt_file', 'workflow_updated_at', 'workflow_updated_by',
        'buku_cetak_diserahkan', 'buku_digital_diserahkan',
    ];

    protected $casts = [
        'data' => 'array',
        'booking_date' => 'date',
        'workflow_updated_at' => 'datetime',
        'buku_cetak_diserahkan' => 'boolean',
        'buku_digital_diserahkan' => 'boolean',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getUserDateGroupAttribute()
    {
        /** @var \Illuminate\Support\Carbon|null $bookingDate */
        $bookingDate = $this->booking_date;
        return $this->user_id . '_' . ($bookingDate ? $bookingDate->format('Y-m-d') : 'no_date');
    }

    /**
     * Check if this submission needs revision.
     */
    public function needsRevision(): bool
    {
        return $this->workflow_status === 'perlu_diperbaiki';
    }

    /**
     * Accessor for title.
     */
    public function getTitleAttribute(): string
    {
        if (empty($this->data)) return '-';
        foreach (['Judul', 'judul', 'Judul Naskah', 'Judul Buku'] as $key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }
        }
        return '-';
    }

    /**
     * Accessor for author.
     */
    public function getAuthorAttribute(): string
    {
        if (empty($this->data)) return '-';
        foreach (['Kepengarangan', 'Kepengarangan ', 'Penulis', 'penulis', 'Pengarang'] as $key) {
            if (isset($this->data[$key])) {
                return trim($this->data[$key]);
            }
        }
        return '-';
    }

    /**
     * Accessor for publisher.
     */
    public function getPublisherAttribute(): string
    {
        if (empty($this->data)) return 'Perpustakaan Kemenag';
        foreach (['Penerbit', 'penerbit'] as $key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }
        }
        return 'Perpustakaan Kemenag';
    }

    /**
     * Accessor for publication year.
     */
    public function getPublicationYearAttribute(): string
    {
        if (empty($this->data)) return '-';
        foreach (['Tahun Terbit', 'tahun_terbit', 'Tahun', 'tahun'] as $key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }
        }
        return '-';
    }

    /**
     * Accessor for unit kerja / satuan kerja.
     */
    public function getUnitKerjaAttribute(): string
    {
        if (empty($this->data)) return '-';
        foreach ($this->data as $key => $value) {
            $normalizedKey = strtolower(trim($key));
            if (
                $normalizedKey === 'unit kerja / satuan kerja pemohon' ||
                $normalizedKey === 'unit kerja/satuan kerja pemohon' ||
                $normalizedKey === 'unit kerja' ||
                $normalizedKey === 'satuan kerja'
            ) {
                return !empty($value) ? $value : '-';
            }
        }
        return '-';
    }

    /**
     * Accessor for instansi type.
     */
    public function getInstansiTypeAttribute()
    {
        if (empty($this->data)) return null;
        foreach (['Tipe Instansi', 'tipe_instansi', 'Tipe', 'tipe'] as $key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }
        }
        return null;
    }

    /**
     * Accessor for instansi name.
     */
    public function getInstansiNameAttribute()
    {
        if (empty($this->data)) return null;
        foreach (['Nama Instansi', 'nama_instansi', 'Nama', 'nama'] as $key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }
        }
        return null;
    }

    /**
     * Accessor for instansi label.
     */
    public function getInstansiLabelAttribute(): string
    {
        $type = strtolower($this->instansi_type ?? '');
        if (str_contains($type, 'kanwil')) return 'Kantor Wilayah (Kanwil)';
        if (str_contains($type, 'kemenag') || str_contains($type, 'kabupaten') || str_contains($type, 'kota')) return 'Kemenag Kabupaten/Kota';
        if (str_contains($type, 'madrasah') || str_contains($type, 'sekolah')) return 'Madrasah';
        return 'Instansi';
    }

    /**
     * Accessor for cover image URL.
     */
    public function getCoverUrlAttribute(): ?string
    {
        if (empty($this->data)) return null;
        foreach (['Cover Buku (format jpg/jpeg/png)', 'Cover Buku', 'cover', 'Cover'] as $key) {
            if (!empty($this->data[$key])) {
                return asset('storage/' . $this->data[$key]);
            }
        }
        return null;
    }

    /**
     * Accessor for synopsis.
     */
    public function getSynopsisAttribute(): string
    {
        if (empty($this->data)) return '-';
        foreach (['Sinopsis Menggambarkan secara ringkas isi terbitan. Minimal 100 kata.', 'Sinopsis', 'sinopsis', 'Keterangan Sinopsis'] as $key) {
            if (!empty($this->data[$key])) {
                return $this->data[$key];
            }
        }
        return '-';
    }

    /**
     * Accessor for edisi.
     */
    public function getEdisiAttribute(): string
    {
        if (empty($this->data)) return '-';
        foreach (['Edisi ', 'Edisi', 'edisi', 'Edisi Contoh: Edisi revisi'] as $key) {
            if (!empty($this->data[$key])) {
                return $this->data[$key];
            }
        }
        return '-';
    }

    /**
     * Accessor for seri.
     */
    public function getSeriAttribute(): string
    {
        if (empty($this->data)) return '-';
        foreach (['Seri (Apablila Buku Berseri)', 'Seri', 'seri'] as $key) {
            if (!empty($this->data[$key])) {
                return $this->data[$key];
            }
        }
        return '-';
    }

    /**
     * Accessor for pages count.
     */
    public function getJumlahHalamanAttribute(): string
    {
        if (empty($this->data)) return '-';
        foreach (['Jumlah Halaman Contoh: viii, 93', 'Jumlah Halaman', 'jumlah_halaman', 'Halaman', 'halaman'] as $key) {
            if (!empty($this->data[$key])) {
                return $this->data[$key];
            }
        }
        return '-';
    }

    /**
     * Accessor for height.
     */
    public function getTinggiBukuAttribute(): string
    {
        if (empty($this->data)) return '-';
        foreach (['Tinggi Buku Contoh: 22', 'Tinggi Buku', 'tinggi_buku', 'Tinggi', 'tinggi'] as $key) {
            if (!empty($this->data[$key])) {
                return $this->data[$key] . ' cm';
            }
        }
        return '-';
    }

    /**
     * Accessor for target readers.
     */
    public function getKelompokPembacaAttribute(): string
    {
        return $this->data['Kelompok Pembaca'] ?? $this->data['kelompok_pembaca'] ?? '-';
    }

    /**
     * Accessor for type of literature.
     */
    public function getJenisPustakaAttribute(): string
    {
        return $this->data['Jenis Pustaka'] ?? $this->data['jenis_pustaka'] ?? '-';
    }

    /**
     * Accessor for categorization of translation.
     */
    public function getKategoriJenisAttribute(): string
    {
        return $this->data['Kategori Jenis'] ?? $this->data['kategori_jenis'] ?? '-';
    }

    /**
     * Accessor for publishing media.
     */
    public function getMediaAttribute(): string
    {
        return $this->data['Media'] ?? $this->data['media'] ?? '-';
    }

    /**
     * Accessor for book category.
     */
    public function getKategoriAttribute(): string
    {
        return $this->data['Kategori'] ?? $this->data['kategori'] ?? '-';
    }

    /**
     * Accessor for download URL of application letter.
     */
    public function getSuratPermohonanUrlAttribute(): ?string
    {
        if (empty($this->data)) return null;
        foreach (['Surat Permohonan ISBN ', 'Surat Permohonan ISBN', 'surat_permohonan'] as $key) {
            if (!empty($this->data[$key])) {
                return asset('storage/' . $this->data[$key]);
            }
        }
        return null;
    }

    /**
     * Accessor for download URL of key elements file.
     */
    public function getFileLampiranUrlAttribute(): ?string
    {
        if (empty($this->data)) return null;
        foreach (['File', 'file', 'Lampiran', 'lampiran'] as $key) {
            if (!empty($this->data[$key])) {
                return asset('storage/' . $this->data[$key]);
            }
        }
        return null;
    }

    /**
     * Accessor for download URL of full dummy file.
     */
    public function getFileDummyUrlAttribute(): ?string
    {
        if (empty($this->data)) return null;
        foreach (['File full dummy (format pdf, max 10 MB)', 'File full dummy', 'file_dummy', 'dummy'] as $key) {
            if (!empty($this->data[$key])) {
                return asset('storage/' . $this->data[$key]);
            }
        }
        return null;
    }

    /**
     * Accessor for download URL of KDT file.
     */
    public function getKdtFileUrlAttribute(): ?string
    {
        return $this->kdt_file ? asset('storage/' . $this->kdt_file) : null;
    }
}
