<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                    Permission::create(['name' => $perm]);
                }

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
                                        $role->permissions()->attach($permission->id);
                                    }
                                }
                            }

                    $users = [
                                [
                                    "name" => "John Doe",
                                    "email" => "test@test.com",
                                    "password" => "secret",
                                    "role_id" => 4, // Student role ID
                                ],
                                [
                                    "name" => "Brad Pitt",
                                    "email" => "test1@test.com",
                                    "password" => "secret",
                                    "role_id" => 1, // Admin role ID
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
