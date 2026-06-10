<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FormSubmission;
use App\Traits\LogsActivity;

class Form extends Model
{
    use LogsActivity;
    protected $fillable = [
        'title', 
        'slug', 
        'description', 
        'fields', 
        'participant_label',
        'quota_count_label',
        'booking_date_label',
        'is_active',
        'cover_image',
        'max_quota',
        'start_date',
        'end_date',
        'guidebook_path',
        'time_slot_label',
        'ticket_bg_image',
        'ticket_name_x', 'ticket_name_y', 'ticket_name_size', 'ticket_name_color',
        'ticket_date_x', 'ticket_date_y', 'ticket_date_size', 'ticket_date_color',
        'theme_color', 'bg_color'
    ];

    protected $casts = [
        'fields' => 'array',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function blockedDates()
    {
        return $this->hasMany(FormBlockedDate::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
