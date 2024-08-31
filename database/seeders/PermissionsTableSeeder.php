<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::create(['name' => 'view_dashboard']);
        Permission::create(['name' => 'view_admin']);
        Permission::create(['name' => 'read_user']);
        Permission::create(['name' => 'create_user']);
        Permission::create(['name' => 'update_user']);
        Permission::create(['name' => 'delete_user']);
        Permission::create(['name' => 'read_role']);
        Permission::create(['name' => 'create_role']);
        Permission::create(['name' => 'update_role']);
        Permission::create(['name' => 'delete_role']);
        Permission::create(['name' => 'read_permission']);
        Permission::create(['name' => 'create_permission']);
        Permission::create(['name' => 'update_permission']);
        Permission::create(['name' => 'delete_permission']);
    }
}
