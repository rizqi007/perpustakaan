<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilBalai extends Model
{
    protected $fillable = [
        'image',
        'nama_balai',
        'slug',
        'description',
        'author',
    ];
}
