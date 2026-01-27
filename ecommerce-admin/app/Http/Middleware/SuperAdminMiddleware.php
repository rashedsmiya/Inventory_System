<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isSuperAdmin()) {
            return redirect('/admin/dashboard')->with('error', 'Only super administrators can access this area.');
        }

        return $next($request);
    }
}
