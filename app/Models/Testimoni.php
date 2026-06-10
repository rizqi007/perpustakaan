<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use App\Traits\Trashable;

class Testimoni extends Model
{
    use HasFactory, LogsActivity, Trashable;

    protected $fillable = [
        'name',
        'institution',
        'quote',
        'photo',
        'video',
        'youtube_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessor untuk mendapatkan URL video
    public function getVideoUrlAttribute()
    {
        return $this->video ? asset('storage/' . $this->video) : null;
    }

    // Accessor untuk mendapatkan URL photo
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    // Check apakah ada video lokal
    public function hasLocalVideo()
    {
        return !empty($this->video);
    }

    // Check apakah ada YouTube video
    public function hasYouTubeVideo()
    {
        return !empty($this->youtube_url);
    }
}