<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Trashable;

class Anggota extends Model
{
    use HasFactory, Trashable;

    protected $fillable = [
        'nip',
        'nama',
        'gender',
        'birth_date',
        'member_type_id',
        'alamat',
        'alamat_surat',
        'kode_pos',
        'email',
        'no_hp',
        'no_faks',
        'institusi',
        'foto',
        'member_since_date',
        'register_date',
        'expire_date',
        'catatan',
        'status',
        'catatan_admin',
        'is_pending',
        'approved_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'member_since_date' => 'date',
        'register_date' => 'date',
        'expire_date' => 'date',
        'is_pending' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    protected static function booted()
    {
        static::saved(function ($anggota) {
            // Trigger SLiMS database sync if membership is approved
            if ($anggota->isApproved() && ($anggota->wasChanged('status') || $anggota->wasRecentlyCreated)) {
                \App\Services\SlimsSyncService::sync($anggota);
            }
        });
    }
}
