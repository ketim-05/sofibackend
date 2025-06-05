<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // First, delete any existing admin user
        User::where('email', 'admin@sofi.com')->delete();

        // Create new admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@sofi.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@sofi.com');
        $this->command->info('Password: admin123');
    }
} 