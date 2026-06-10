<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'orientation',
        'background_image',
        'overlay_color',
        'overlay_opacity',
        'logo_position',
        'photo_position',
        'name_position',
        'nip_position',
        'institution_position',
        'validity_position',
        'is_active',
    ];

    protected $casts = [
        'logo_position' => 'array',
        'photo_position' => 'array',
        'name_position' => 'array',
        'nip_position' => 'array',
        'institution_position' => 'array',
        'validity_position' => 'array',
        'is_active' => 'boolean',
        'overlay_opacity' => 'float',
    ];

    /**
     * Get the active card template.
     */
    public static function getActive(): ?self
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Activate this template and deactivate others.
     */
    public function activate(): void
    {
        static::where('is_active', true)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }

    /**
     * Deactivate this template.
     */
    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }
}
