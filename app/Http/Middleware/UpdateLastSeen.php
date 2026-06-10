<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next, string $guard = null): Response
    {
        // Gunakan guard yang diberikan, atau deteksi otomatis berdasarkan path
        $guardName = $guard;

        if (!$guardName) {
            $guardName = str_contains($request->path(), 'SmartPanel') ? 'admin' : 'web';
        }

        if (auth()->guard($guardName)->check()) {
            $user = auth()->guard($guardName)->user();

            // Update hanya jika lebih dari 1 menit sejak terakhir update (untuk performa)
            if (!$user->last_seen_at || now()->diffInMinutes(Carbon::parse($user->last_seen_at)) >= 1) {
                $user->forceFill(['last_seen_at' => now()])->saveQuietly();
            }
        }

        return $next($request);
    }
}
