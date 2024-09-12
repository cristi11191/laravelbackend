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
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array', // Validating permissions as an array
            'permissions.*' => 'integer', // Each permission should be an integer (ID)
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->permissions = $request->permissions ?? []; // Store the permissions array
        $role->save();

        return response()->json($role, 201);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->permissions = $request->input('permissions'); // Store permissions as JSON
        $role->save();

        return response()->json($role);
    }


    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['error' => 'Role not found.'], 404);
        }

        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }
    public function getPermissions($roleId)
    {
        // Find the role by ID
        $role = Role::findOrFail($roleId);

        // Return a JSON response with the role's permissions
        return response()->json([
            'role_id' => $role->id,
            'permissions' => $role->permissions, // This will return the permissions array
        ], 200);
    }

    /**
     * Update the permissions for a specific role.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRole(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array' // Ensure permissions is an array
        ]);

        // Check user permissions
        if (!auth()->user()->hasPermission('update_role')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Find the role and update it
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->permissions = json_encode($request->input('permissions')); // Assuming permissions is a JSON column
        $role->save();

        return response()->json(['message' => 'Role updated successfully']);
    }


}
