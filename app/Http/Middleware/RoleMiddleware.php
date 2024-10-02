<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // Ensure that user is authenticated and their role matches one of the allowed roles
            if (! $user || ! in_array($user->role->name, $roles)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token error'], 401);
        }

        return $next($request);
    }
}
