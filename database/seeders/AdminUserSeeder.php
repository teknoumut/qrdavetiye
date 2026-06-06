<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@qr-davetiye.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@qr-davetiye.com',
                'password' => Hash::make('Admin123!'),
                'is_admin' => true,
                'is_active' => true,
                'subscription_start' => now(),
                'subscription_end' => now()->addYears(10),
                'email_verified_at' => now(),
            ]
        );
    }
}
