<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('secret'), // Set a strong password
            'role_id' => 1, // Assuming role_id 1 is for Admin
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'user@test.com',
            'password' => Hash::make('secret'),
            'role_id' => 4, // Assuming role_id 2 is for a regular user
        ]);
    }
}
