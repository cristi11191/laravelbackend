<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithApiGuard
{
    public function handle($request, Closure $next, $guard = 'api')
    {
        if (Auth::guard($guard)->guest()) {
            // Check if the issue is related to the token
            $token = $request->bearerToken();

            if ($token && !Auth::guard($guard)->check()) {
                // Assuming the token is invalid
                return response()->json(['error' => 'Token Invalid'], 401);
            }

            // For other unauthorized cases
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
