<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Models\RolePermission; // Make sure this is imported

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Step 1: Create Permissions
        $permissions = [
            'view_dashboard',
            'view_adminpanel',
            'read_user',
            'create_user',
            'update_user',
            'delete_user',
            'read_role',
            'create_role',
            'update_role',
            'delete_role',
            'read_permission',
            'create_permission',
            'update_permission',
            'delete_permission',
        ];

        foreach ($permissions as $perm) {
            // Check if the permission already exists
            if (!Permission::where('name', $perm)->exists()) {
                Permission::create(['name' => $perm]);
            }
        }

        // Step 2: Create Roles and Attach Permissions
        $roles = [
            'admin' => [
                'permissions' => $permissions, // Admin has all permissions
            ],
            'secretary' => [
                'permissions' => [
                    'view_dashboard',
                    'view_adminpanel',
                    'read_user',
                    'create_user',
                    'update_user',
                    'delete_user',
                ],
            ],
            'teacher' => [
                'permissions' => [
                    'view_dashboard',
                    'read_user',
                    'create_user',
                    'update_user',
                ],
            ],
            'student' => [
                'permissions' => [
                    'view_dashboard',
                ],
            ],
        ];

        foreach ($roles as $roleName => $roleData) {
            $role = Role::create(['name' => ucfirst($roleName)]); // Capitalize role names

            // Attach permissions to the role
            foreach ($roleData['permissions'] as $perm) {
                $permission = Permission::where('name', $perm)->first();
                if ($permission) {
                    RolePermission::create([
                        'role_id' => $role->id,
                        'permission_id' => $permission->id,
                    ]);
                }
            }
        }

        // Step 3: Create Users
        $users = [
            [
                "name" => "John Doe",
                "email" => "test@test.com",
                "password" => "secret",
                "role_id" => 4, // Assuming this is Student
            ],
            [
                "name" => "Brad Pitt",
                "email" => "test1@test.com",
                "password" => "secret",
                "role_id" => 1, // Assuming this is Admin
            ],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']), // Hash the password
                'role_id' => $userData['role_id'],
            ]);
        }
    }
}
