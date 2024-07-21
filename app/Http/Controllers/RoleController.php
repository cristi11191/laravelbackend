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
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        return response()->json($role, 201);
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
}
