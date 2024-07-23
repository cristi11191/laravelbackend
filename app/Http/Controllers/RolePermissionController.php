<?php
// RolePermissionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RolePermission;

class RolePermissionController extends Controller
{
    // Store role-permission relationships
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        foreach ($request->permissions as $permissionId) {
            RolePermission::create([
                'role_id' => $request->role_id,
                'permission_id' => $permissionId,
            ]);
        }

        return response()->json(['message' => 'Permissions added successfully'], 201);
    }

    // Detach permissions from a role
    public function destroy(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        RolePermission::where('role_id', $request->role_id)
            ->whereIn('permission_id', $request->permissions)
            ->delete();

        return response()->json(['message' => 'Permissions removed successfully'], 200);
    }
}
