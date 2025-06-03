<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update admin user
        User::updateOrCreate(
            ['email' => 'admin@sofistudio.com'],
            [
                'name' => 'Sultan Nuri',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now()
            ]
        );

        // Create or update additional admin user
        User::updateOrCreate(
            ['email' => 'sultan@sofistudio.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now()
            ]
        );
    }
}
