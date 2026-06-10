<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class LibraryProfile extends Model
{
    use LogsActivity;
    protected $fillable = [
        'visi',
        'misi',
        'tagline',
        'functions',
        'tasks',
        'legal_bases',
        'milestones',
        'collections',
    ];

    protected $casts = [
        'misi' => 'array',
        'functions' => 'array',
        'tasks' => 'array',
        'legal_bases' => 'array',
        'milestones' => 'array',
        'collections' => 'array',
    ];
}