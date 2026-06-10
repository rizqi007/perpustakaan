<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormBlockedDate extends Model
{
    protected $fillable = [
        'form_id',
        'booking_date',
        'session_time',
        'reason',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
