<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User untuk Login Web Dashboard Admin
        User::updateOrCreate(
            ['email' => 'admin@tokoroti.com'],
            [
                'name' => 'Administrator',
                'phone' => '081234567890',
                'password' => Hash::make('admin123'),
            ]
        );

        // User Customer Test
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '089876543210',
                'password' => Hash::make('password123'),
            ]
        );

        $this->call(ProductSeeder::class);
    }
}
