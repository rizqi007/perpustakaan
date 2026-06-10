<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'visit_date',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];
}
