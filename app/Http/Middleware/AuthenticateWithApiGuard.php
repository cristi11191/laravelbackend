<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithApiGuard
{
    public function handle($request, Closure $next, $guard = 'api')
    {
        if (Auth::guard($guard)->guest()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
