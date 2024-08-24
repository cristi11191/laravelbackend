<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
            DB::table('roles')->truncate();
            DB::table('permissions')->truncate();
            DB::table('role_permission')->truncate();

            $this->call(RolesAndUsersSeeder::class);
    }
}
