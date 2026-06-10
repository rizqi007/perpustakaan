<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewIsbnSubmissionNotification;
use App\Traits\LogsActivity;
use App\Traits\Trashable;

class IsbnSubmission extends Model
{
    use LogsActivity, Trashable;

    protected static function booted(): void
    {
        static::created(function (IsbnSubmission $submission) {
            $admins = User::whereIn('role', ['admin', 'superadmin'])->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewIsbnSubmissionNotification($submission));
            }
        });
    }

    // Legacy status constants (kept for backward compatibility)
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Workflow status constants (8 tahap proses)
    const WORKFLOW_DATA_DITERIMA      = 'data_diterima';
    const WORKFLOW_VERIFIKASI_KEMENAG = 'verifikasi_kemenag';
    const WORKFLOW_PERLU_DIPERBAIKI   = 'perlu_diperbaiki';
    const WORKFLOW_PROSES_PENGAJUAN   = 'proses_pengajuan';
    const WORKFLOW_VERIFIKASI_PERPUSNAS = 'verifikasi_perpusnas';
    const WORKFLOW_ISBN_TERBIT        = 'isbn_terbit';
    const WORKFLOW_PENYERAHAN_BUKU    = 'penyerahan_buku';
    const WORKFLOW_SELESAI            = 'selesai';

    // Ordered workflow steps
    const WORKFLOW_STEPS = [
        self::WORKFLOW_DATA_DITERIMA,
        self::WORKFLOW_VERIFIKASI_KEMENAG,
        self::WORKFLOW_PERLU_DIPERBAIKI,
        self::WORKFLOW_PROSES_PENGAJUAN,
        self::WORKFLOW_VERIFIKASI_PERPUSNAS,
        self::WORKFLOW_ISBN_TERBIT,
        self::WORKFLOW_PENYERAHAN_BUKU,
        self::WORKFLOW_SELESAI,
    ];

    const WORKFLOW_LABELS = [
        'data_diterima'        => 'Data Diterima',
        'verifikasi_kemenag'   => 'Verifikasi Kemenag',
        'perlu_diperbaiki'     => 'Perlu Diperbaiki',
        'proses_pengajuan'     => 'Proses Pengajuan',
        'verifikasi_perpusnas' => 'Verifikasi Perpusnas',
        'isbn_terbit'          => 'ISBN Terbit',
        'penyerahan_buku'      => 'Penyerahan Buku',
        'selesai'              => 'Selesai',
    ];

    const INSTANSI_LABELS = [
        'kanwil'   => 'Kantor Wilayah (Kanwil)',
        'kemenag'  => 'Kemenag Kabupaten/Kota',
        'madrasah' => 'Madrasah',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'publisher',
        'publication_year',
        'isbn',
        'pages',
        'language',
        'file_path',
        'file_original_name',
        'description',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'admin_notes',
        // Workflow fields
        'workflow_status',
        'instansi_type',
        'instansi_name',
        'revision_notes',
        'isbn_number',
        'workflow_updated_at',
        'workflow_updated_by',
    ];

    protected $casts = [
        'reviewed_at'         => 'datetime',
        'workflow_updated_at' => 'datetime',
        'publication_year'    => 'integer',
        'pages'               => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function workflowUpdatedBy()
    {
        return $this->belongsTo(User::class, 'workflow_updated_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    // Accessors
    public function getFileUrlAttribute()
    {
        return asset('storage/isbn_submissions/' . $this->file_path);
    }

    public function getWorkflowLabelAttribute(): string
    {
        return self::WORKFLOW_LABELS[$this->workflow_status] ?? ucfirst($this->workflow_status);
    }

    public function getInstansiLabelAttribute(): string
    {
        return self::INSTANSI_LABELS[$this->instansi_type] ?? ucfirst($this->instansi_type ?? '-');
    }

    /**
     * Current step index (0-based) out of 8 total steps.
     * Note: step index 2 (perlu_diperbaiki) is a branch/side state,
     * display logic handles it separately.
     */
    public function getWorkflowStepIndexAttribute(): int
    {
        $steps = [
            'data_diterima'        => 0,
            'verifikasi_kemenag'   => 1,
            'perlu_diperbaiki'     => 1, // same visual position as verifikasi_kemenag
            'proses_pengajuan'     => 2,
            'verifikasi_perpusnas' => 3,
            'isbn_terbit'          => 4,
            'penyerahan_buku'      => 5,
            'selesai'              => 6,
        ];
        return $steps[$this->workflow_status] ?? 0;
    }

    public function needsRevision(): bool
    {
        return $this->workflow_status === self::WORKFLOW_PERLU_DIPERBAIKI;
    }

    public function isCompleted(): bool
    {
        return $this->workflow_status === self::WORKFLOW_SELESAI;
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING  => '<span class="badge bg-warning">Pending</span>',
            self::STATUS_APPROVED => '<span class="badge bg-success">Approved</span>',
            self::STATUS_REJECTED => '<span class="badge bg-danger">Rejected</span>',
            default               => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getWorkflowBadgeColorAttribute(): string
    {
        return match($this->workflow_status) {
            'data_diterima'        => 'blue',
            'verifikasi_kemenag'   => 'yellow',
            'perlu_diperbaiki'     => 'red',
            'proses_pengajuan'     => 'indigo',
            'verifikasi_perpusnas' => 'purple',
            'isbn_terbit'          => 'green',
            'penyerahan_buku'      => 'teal',
            'selesai'              => 'emerald',
            default                => 'gray',
        };
    }
}
