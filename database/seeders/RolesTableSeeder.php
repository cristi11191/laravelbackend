<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'permissions' => json_encode(['view_dashboard', 'view_admin', 'read_user', 'create_user', 'update_user', 'delete_user', 'read_role', 'create_role', 'update_role', 'delete_role', 'read_permission', 'create_permission', 'update_permission', 'delete_permission'])
        ]);

        Role::create([
            'name' => 'Secretary',
            'permissions' => json_encode(['view_dashboard', 'read_user', 'create_user'])
        ]);

        Role::create([
            'name' => 'Teacher',
            'permissions' => json_encode(['view_dashboard', 'read_user'])
        ]);

        Role::create([
            'name' => 'Student',
            'permissions' => json_encode(['view_dashboard'])
        ]);
    }
}
