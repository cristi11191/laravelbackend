<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $viewDashboard = Permission::where('name', 'view_dashboard')->first();
        $adminRole->permissions()->attach($viewDashboard);
        $viewAdminPanel = Permission::where('name', 'view_admin')->first();
        $adminRole->permissions()->attach($viewAdminPanel);
    }
}
