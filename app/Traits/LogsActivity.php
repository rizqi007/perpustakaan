<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logActivity('create', $model);
        });

        static::updated(function ($model) {
            self::logActivity('update', $model);
        });

        static::deleted(function ($model) {
            self::logActivity('delete', $model);
        });
    }

    protected static function logActivity($action, $model)
    {
        if (!Auth::check()) {
            return;
        }

        $description = ucfirst($action) . " " . class_basename($model);
        
        // Optional: Add specific details like Title or Name if available
        if (isset($model->title)) {
            $description .= ": " . $model->title;
        } elseif (isset($model->name)) {
            $description .= ": " . $model->name;
        } else {
             $description .= " #" . $model->id;
        }

        // Truncate fields to 250 characters + suffix, and use mb_substr to guarantee <= 255 characters
        $description = mb_substr(\Illuminate\Support\Str::limit($description, 250), 0, 255);
        $userAgent = mb_substr(\Illuminate\Support\Str::limit(Request::userAgent(), 250), 0, 255);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'details' => $action === 'update' ? $model->getChanges() : $model->toArray(),
            'ip_address' => Request::ip(),
            'user_agent' => $userAgent,
        ]);
    }
}
