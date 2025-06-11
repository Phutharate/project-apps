<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleDriverMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'driver') {
            return $next($request);
        }

        abort(403, 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
    }
}
