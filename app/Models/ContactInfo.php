<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class ContactInfo extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'address',
        'phone',
        'email',
        'monday_thursday',
        'friday',
        'saturday',
        'sunday',
        'map_embed_url',
        'map_latitude',
        'map_longitude',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the active contact info
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }
}