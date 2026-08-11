<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin yarat
        User::create([
            'name' => 'Admin',
            'email' => 'admin@fleet.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Müdiriyyət
        User::create([
            'name' => 'Müdiriyyət',
            'email' => 'directorate@fleet.com',
            'password' => Hash::make('password'),
            'role' => 'directorate',
        ]);

        // Şikayət işçisi
        User::create([
            'name' => 'Şikayət İşçisi',
            'email' => 'complaint@fleet.com',
            'password' => Hash::make('password'),
            'role' => 'complaint',
        ]);

        // Anbar işçisi
        User::create([
            'name' => 'Anbar İşçisi',
            'email' => 'warehouse@fleet.com',
            'password' => Hash::make('password'),
            'role' => 'warehouse',
        ]);
    }
}
