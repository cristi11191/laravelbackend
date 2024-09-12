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
        if (!$user || !$user->role) {
            return response()->json(['error' => 'User not found or has no role'], 404);
        }

        // Get the permissions from the role
        $permissions = $user->role->permissions;

        // Check if the required permission exists in the stored names
        if (!in_array($permission, $permissions)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }


}

