<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class WebsiteSetting extends Model
{
    use LogsActivity;
    protected $fillable = [
        'site_name',
        'website_font',
        'favicon',
        'logo',
        'maintenance_mode',
        'maintenance_message',
        'notification_banner_enabled',
        'notification_banner_text',
        'instagram_embed_code',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url',
    ];
    
    protected $casts = [
        'maintenance_mode' => 'boolean',
        'notification_banner_enabled' => 'boolean',
    ];
    
    /**
     * Get the singleton instance of website settings
     */
    public static function get()
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([
                'site_name' => 'Perpustakaan Digital',
                'maintenance_mode' => false,
                'notification_banner_enabled' => false,
            ]);
        }
        
        return $settings;
    }
}
