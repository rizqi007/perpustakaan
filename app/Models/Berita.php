<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use App\Traits\Trashable;

class Berita extends Model
{
    use HasFactory, LogsActivity, Trashable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'is_published', // Pastikan baris ini ada
        'published_at', // Pastikan baris ini ada
    ];

    protected $casts = [
        'is_published' => 'boolean', // Pastikan baris ini ada
        'published_at' => 'datetime', // Pastikan baris ini ada
    ];
}