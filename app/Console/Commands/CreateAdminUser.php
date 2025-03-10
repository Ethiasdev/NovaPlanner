<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {name?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name') ?? $this->ask('What is the admin name?', 'Admin');
        $email = $this->argument('email') ?? $this->ask('What is the admin email?', 'admin@example.com');
        $password = $this->argument('password') ?? $this->secret('What is the admin password?') ?? 'password';

        // Check if user exists
        $user = User::where('email', $email)->first();
        
        if ($user) {
            $this->info("User with email {$email} already exists.");
            
            if (!$this->confirm('Do you want to make this user an admin?')) {
                return 1;
            }
        } else {
            // Create new user
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
            
            $this->info("User created: {$name} ({$email})");
        }
        
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrator with full access']
        );
        
        // Assign role to user if not already assigned
        if (!$user->hasRole('admin')) {
            $user->roles()->attach($adminRole);
            $this->info("Admin role assigned to {$email}");
        } else {
            $this->info("User already has admin role");
        }
        
        $this->info("Admin user is ready. You can now log in at /login with {$email}");
        
        return 0;
    }
} 