<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function all()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function show($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'Role not found.'], 404);
        }

        $permissions = $role->permissions;
        return response()->json(['role' => $role, 'permissions' => $permissions]);
    }
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array', // Permissions should be an array
            'permissions.*' => 'integer|exists:permissions,id', // Ensure each permission ID is valid
        ]);

        // Create role
        $role = Role::create([
            'name' => $request->name,
        ]);

        // Attach permissions to the role
        if ($request->has('permissions') && !empty($request->permissions)) {
            foreach ($request->permissions as $permissionId) {
                RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        return response()->json($role->load('permissions'), 201);
    }


    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['error' => 'Role not found.'], 404);
        }

        $request->validate([
            'name' => 'string|unique:roles,name,'.$role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update([
            'name' => $request->name ?? $role->name,
        ]);

        if ($request->has('permissions')) {
            RolePermission::where('role_id', $role->id)->delete();
            foreach ($request->permissions as $permission_id) {
                RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id,
                ]);
            }
        }

        return response()->json($role);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['error' => 'Role not found.'], 404);
        }

        RolePermission::where('role_id', $role->id)->delete();
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }
    public function getPermissions($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'Role not found.'], 404);
        }

        $permissions = $role->permissions;
        return response()->json($permissions);
    }
    /**
     * Update the permissions for a specific role.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePermissions(Request $request, $id)
    {
        \Log::info('Updating permissions for role ID: '.$id); // Log the role ID

        $role = Role::find($id);
        if (!$role) {
            return response()->json(['error' => 'Role not found.'], 404);
        }

        // Validate request
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        // Remove old permissions
        RolePermission::where('role_id', $role->id)->delete();

        // Attach new permissions
        if ($request->has('permissions') && !empty($request->permissions)) {
            foreach ($request->permissions as $permissionId) {
                RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        return response()->json(['message' => 'Permissions updated successfully']);
    }
}
