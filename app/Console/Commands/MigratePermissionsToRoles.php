<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class MigratePermissionsToRoles extends Command
{
    protected $signature = 'migrate:permissions-to-roles';
    protected $description = 'Migrate permissions from pivot table to roles table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get all roles
        $roles = Role::all();

        foreach ($roles as $role) {
            // Get all permissions for this role from the pivot table
            $permissionIds = DB::table('role_permission')
                ->where('role_id', $role->id)
                ->pluck('permission_id');

            // Convert the collection to an array and store it in the permissions column
            $role->permissions = $permissionIds->toArray();
            $role->save();

            $this->info("Permissions for role '{$role->name}' have been migrated.");
        }

        $this->info('Migration completed.');
    }
}
