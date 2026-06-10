<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  The required role (admin or superadmin)
     */
    public function handle(Request $request, Closure $next, string $role = 'admin'): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        
        $user = auth()->user();
        
        // Superadmin has access to everything
        if ($user->role === 'superadmin') {
            return $next($request);
        }
        
        // Check if user has the required role
        if ($role === 'admin' && $user->role === 'admin') {
            return $next($request);
        }
        
        // If role is superadmin and user is not superadmin, deny access
        if ($role === 'superadmin' && $user->role !== 'superadmin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // Default deny
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
