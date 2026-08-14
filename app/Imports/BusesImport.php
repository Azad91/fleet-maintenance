<?php

namespace App\Imports;

use App\Models\Bus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BusesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Sənin Excel çıxışına əsasən dəqiq sahələr:
        $dqn      = trim($row['dqn'] ?? '');
        $project  = $row['bus_project'] ?? null;
        $vin      = $row['vin'] ?? null;
        $uzunluq  = $row['uzunluq'] ?? null;
        $xett_no  = $row['xett'] ?? null;    // BURADA "xett_no" YOX, "xett"!
        $motor_no = $row['motor'] ?? null;   // BURADA "motor_no" YOX, "motor"!

        if (empty($dqn)) {
            return null;
        }

        // Uzunluq rəqəmə çevir (əgər metr varsa)
        $uzunluq = $uzunluq ? (float) preg_replace('/[^0-9.]/', '', $uzunluq) : null;

        return Bus::updateOrCreate(
            ['dqn' => $dqn],
            [
                'bus_project' => $project,
                'vin'         => $vin,
                'uzunluq'     => $uzunluq,
                'xett_no'     => $xett_no,
                'motor_no'    => $motor_no,
                'tarix'       => now()->format('Y-m-d'),
                'aktiv'       => true,
            ]
        );
    }
}
