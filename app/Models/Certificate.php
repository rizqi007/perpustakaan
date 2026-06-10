<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'title',
        'background_image',
        'name_field',
        'name_y',
        'name_font_size',
        'name_color',
        'name_font_family',
        'description',
        'signature_name',
        'signature_title',
        'signature_image',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
