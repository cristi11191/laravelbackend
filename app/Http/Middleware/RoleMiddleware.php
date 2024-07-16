<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user || $user->role !== $role) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token error'], 401);
        }

        return $next($request);
    }
}
