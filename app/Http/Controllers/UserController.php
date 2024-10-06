<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        return response()->json($user);
    }
    public function toggleStatus($id)
    {
        // Find the user or return a 404 error
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Toggle the user's status (active/inactive)
        $user->status = !$user->status; // Toggle between true (active) and false (inactive)
        $user->save();

        return response()->json(['message' => 'User status updated successfully', 'status' => $user->status]);
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6', // Password is now optional
            'role_id' => 'nullable|integer|exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->has('password') ? bcrypt($request->password) : $user->password,
            'role_id' => $request->role_id ?? $user->role_id,
        ]);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }


}
