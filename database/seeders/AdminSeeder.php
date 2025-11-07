<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $admin = User::where('email', 'admin@destrosolutions.com')->first();
        
        if (!$admin) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@destrosolutions.com',
                'password' => Hash::make('destro@1234'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin user created successfully!');
        } else {
            // Update existing user to be admin
            $admin->update([
                'is_admin' => true,
                'password' => Hash::make('destro@1234'),
            ]);
            
            $this->command->info('Admin user updated successfully!');
        }
    }
}
