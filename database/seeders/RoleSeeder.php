<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role
        Role::create([
            'name' => 'admin',
            'description' => 'Administrator with full access',
        ]);

        // Create user role
        Role::create([
            'name' => 'user',
            'description' => 'Regular user with limited access',
        ]);
    }
}
