<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@raathbackend.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@raathbackend.com',
                'password' => Hash::make('Admin@123'),
                'phone' => '+977-9800000000',
                'address' => 'Kathmandu, Nepal',
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create Test User
        User::updateOrCreate(
            ['email' => 'user@raathbackend.com'],
            [
                'name' => 'Test User',
                'email' => 'user@raathbackend.com',
                'password' => Hash::make('User@123'),
                'phone' => '+977-9800000001',
                'address' => 'Kathmandu, Nepal',
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin users created successfully!');
        $this->command->info('');
        $this->command->info('🔐 Login Credentials:');
        $this->command->info('==========================================');
        $this->command->info('👤 Admin Login:');
        $this->command->info('   Email: admin@raathbackend.com');
        $this->command->info('   Password: Admin@123');
        $this->command->info('');
        $this->command->info('👤 Test User Login:');
        $this->command->info('   Email: user@raathbackend.com');
        $this->command->info('   Password: User@123');
        $this->command->info('==========================================');
    }
}
