<?php

namespace Database\Seeders;

use App\Models\ServiceTemplate;
use Illuminate\Database\Seeder;

class ServiceTemplateSeeder extends Seeder
{
    public function run(): void
    {
        ServiceTemplate::create([
            'name' => 'Koropka Yağ Dəyişməsi',
            'default_km_interval' => 180000,
            'details' => [
                ['kodu' => 'YAG-001', 'adi' => 'Koropka Yağı', 'miqdar' => 3],
                ['kodu' => 'FIL-002', 'adi' => 'Yağ Filtri', 'miqdar' => 1],
            ]
        ]);

        ServiceTemplate::create([
            'name' => 'Most Yağ Dəyişməsi',
            'default_km_interval' => 180000,
            'details' => [
                ['kodu' => 'YAG-003', 'adi' => 'Most Yağı', 'miqdar' => 5],
            ]
        ]);

        ServiceTemplate::create([
            'name' => 'Motor Yağ Dəyişməsi (36000)',
            'default_km_interval' => 36000,
            'details' => [
                ['kodu' => 'YAG-004', 'adi' => 'Motor Yağı', 'miqdar' => 5],
                ['kodu' => 'FIL-001', 'adi' => 'Yağ Filtri', 'miqdar' => 1],
            ]
        ]);

        ServiceTemplate::create([
            'name' => 'Motor Yağ Dəyişməsi (72000)',
            'default_km_interval' => 72000,
            'details' => [
                ['kodu' => 'YAG-004', 'adi' => 'Motor Yağı', 'miqdar' => 5],
                ['kodu' => 'FIL-001', 'adi' => 'Yağ Filtri', 'miqdar' => 1],
                ['kodu' => 'AIR-001', 'adi' => 'Hava Filtri', 'miqdar' => 1],
            ]
        ]);
    }
}
