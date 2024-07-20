<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user || !$user->role || !$user->role->permissions->contains('name', $permission)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}

