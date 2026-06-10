<?php

namespace App\Http\Middleware;

use App\Models\WebsiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = WebsiteSetting::get();

        if ($settings->maintenance_mode) {
            // Allow admin users through
            if (auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin'])) {
                return $next($request);
            }

            $message = $settings->maintenance_message ?: 'Website sedang dalam perbaikan. Silakan kunjungi kembali nanti.';

            return response()->view('maintenance', [
                'message' => $message,
                'siteName' => $settings->site_name,
            ], 503);
        }

        return $next($request);
    }
}
