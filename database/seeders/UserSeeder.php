<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@fleet.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Müdiriyyət
        User::updateOrCreate(
            ['email' => 'directorate@fleet.com'],
            [
                'name' => 'Müdiriyyət',
                'password' => Hash::make('password'),
                'role' => 'directorate',
            ]
        );

        // Şikayət işçisi
        User::updateOrCreate(
            ['email' => 'complaint@fleet.com'],
            [
                'name' => 'Şikayət İşçisi',
                'password' => Hash::make('password'),
                'role' => 'complaint',
            ]
        );

        // Anbar işçisi
        User::updateOrCreate(
            ['email' => 'warehouse@fleet.com'],
            [
                'name' => 'Anbar İşçisi',
                'password' => Hash::make('password'),
                'role' => 'warehouse',
            ]
        );
    }
}
