<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip admin routes and bots
        if ($request->is('admin/*') || $request->is('livewire/*')) {
            return $next($request);
        }

        $ip = $request->ip();
        $today = now()->toDateString();

        // Record unique visitor per day (ignore duplicates)
        Visitor::firstOrCreate(
            [
                'ip_address' => $ip,
                'visit_date' => $today,
            ],
            [
                'user_agent' => substr($request->userAgent() ?? '', 0, 500),
                'url' => substr($request->fullUrl(), 0, 255),
            ]
        );

        return $next($request);
    }
}
