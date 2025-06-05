<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password';
    protected $description = 'Reset the admin password';

    public function handle()
    {
        $admin = User::where('email', 'admin@sofi.com')->first();
        
        if (!$admin) {
            $this->error('Admin user not found!');
            return;
        }

        $admin->password = Hash::make('admin123');
        $admin->save();

        $this->info('Admin password has been reset successfully!');
        $this->info('Email: admin@sofi.com');
        $this->info('Password: admin123');
    }
} 