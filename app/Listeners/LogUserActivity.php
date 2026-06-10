<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

class LogUserActivity
{
    public function handle($event)
    {
        if ($event instanceof Login) {
            ActivityLog::create([
                'user_id' => $event->user->id,
                'action' => 'login',
                'description' => 'User logged in',
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        }

        if ($event instanceof Logout) {
            if ($event->user) {
                ActivityLog::create([
                    'user_id' => $event->user->id,
                    'action' => 'logout',
                    'description' => 'User logged out',
                    'ip_address' => Request::ip(),
                    'user_agent' => Request::userAgent(),
                ]);
            }
        }
    }
}
