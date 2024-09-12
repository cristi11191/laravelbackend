<?php
namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function all()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    public function show($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json(['error' => 'Permission not found.'], 404);
        }

        return response()->json($permission);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        $permission = Permission::create([
            'name' => $request->name,
        ]);

        return response()->json($permission, 201);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json(['error' => 'Permission not found.'], 404);
        }

        $request->validate([
            'name' => 'string|unique:permissions,name,'.$permission->id,
        ]);

        $permission->update([
            'name' => $request->name ?? $permission->name,
        ]);

        return response()->json($permission);
    }

    public function destroy($id)
    {
        // Find the permission to delete
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json(['error' => 'Permission not found.'], 404);
        }

        // Fetch all roles that contain the permission in their permissions array
        $roles = Role::whereJsonContains('permissions', $permission->name)->get();

        // Iterate over each role and remove the permission from their permissions array
        foreach ($roles as $role) {
            // Check if the permissions are stored as an array or JSON string
            $permissions = $role->permissions; // Assuming this is already an array

            // Ensure that $permissions is an array
            if (is_string($permissions)) {
                // Decode it if it's a JSON string
                $permissions = json_decode($permissions, true) ?: [];
            }

            // Remove the permission from the array
            $permissions = array_filter($permissions, function ($permissionName) use ($permission) {
                return $permissionName !== $permission->name; // Remove the permission from the array
            });

            // Assign the updated permissions array directly without JSON encoding
            $role->permissions = array_values($permissions); // Re-index the array
            $role->save(); // Save the updated role
        }

        // Delete the permission itself
        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully, and removed from all roles.']);
    }





}
