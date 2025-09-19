<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.show'); // balik ke login kalau belum login
        }

        // cek role user
        if (Session::get('role') !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
