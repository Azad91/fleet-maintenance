<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class EmployeesImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        // Sütunlar: ad, soyad, vezife (AYRI-AYRI)
        $ad = $row['ad'] ?? null;
        $soyad = $row['soyad'] ?? null;
        $vezife = $row['vezife'] ?? 'digər';

        // Əgər ad boşdursa, keç
        if (empty($ad)) {
            return null;
        }

        // Əgər soyad boşdursa, boş qalsın
        if (empty($soyad)) {
            $soyad = '';
        }

        return new Employee([
            'ad' => $ad,
            'soyad' => $soyad,
            'vezifesi' => $vezife,
            'aktiv' => true,
            'qeyd' => null,
        ]);
    }
}
