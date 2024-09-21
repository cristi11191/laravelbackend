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
        return response()->json(['role' => $role]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return response()->json($role, 201);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
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
            'name' => 'required|string|max:255'
        ]);


        // Find the role and update it
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();

        return response()->json(['message' => 'Role updated successfully']);
    }


}
