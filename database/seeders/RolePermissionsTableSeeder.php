<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RolePermission;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Assuming role_id 1 is Admin and has all permissions
        RolePermission::create(['role_id' => 1, 'permission_id' => 1]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 2]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 3]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 4]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 5]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 6]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 7]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 8]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 9]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 10]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 11]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 12]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 13]);
        RolePermission::create(['role_id' => 1, 'permission_id' => 14]);

        // Assuming role_id 2 is User and has limited permissions
        RolePermission::create(['role_id' => 2, 'permission_id' => 1]);
        RolePermission::create(['role_id' => 3, 'permission_id' => 1]);
        RolePermission::create(['role_id' => 4, 'permission_id' => 1]);
    }
}
