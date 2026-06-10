<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Trashable;

class KatalogBuku extends Model
{
    use Trashable;
    protected $fillable = [
        'form_submission_id',
        'isbn_submission_id',
        'judul_penanggung_jawab',
        'edisi',
        'publikasi',
        'deskripsi_fisik',
        'identifikasi',
        'subjek',
        'klasifikasi',
        'sinopsis',
        'cover',
    ];

    public function formSubmission()
    {
        return $this->belongsTo(FormSubmission::class);
    }

    public function isbnSubmission()
    {
        return $this->belongsTo(IsbnSubmission::class);
    }
}

