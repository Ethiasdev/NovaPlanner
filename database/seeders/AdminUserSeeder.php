<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Using bcrypt via Hash::make
            'email_verified_at' => now(),
        ]);

        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();

        // Assign admin role to user
        $admin->roles()->attach($adminRole);
    }
}
