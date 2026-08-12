<?php

namespace App\Imports;

use App\Models\MotorOilDetail;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class MotorOilImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $rowArray = $row->toArray();

        // Excel - də km sütunları (E - dən başlayır)
        $kmColumns = [
            36000, 72000, 108000, 144000, 180000, 216000, 252000, 288000, 324000,
            360000, 396000, 432000, 468000, 504000, 540000, 576000, 612000, 648000,
            684000, 720000, 756000, 792000, 828000, 864000, 900000, 936000, 972000,
            1008000, 1044000, 1080000, 1116000, 1152000, 1188000, 1224000, 1260000,
            1296000, 1332000, 1368000, 1404000, 1440000
        ];

        // Excel - də sütunlar: A=adi, B=olcu_vahidi, C=miqdar, D=kod, E... = km
        $detal_kodu = $rowArray['kod'] ?? null;
        $detal_adi = $rowArray['adi'] ?? null;
        $olcu_vahidi = $rowArray['olcu_vahidi'] ?? null;
        $miqdar = $rowArray['miqdar'] ?? 0;

        if (!$detal_kodu) return;

        // Hər km sütununu yoxla
        $columnIndex = 4; // E sütunu (0-dan başlayanda 4-cü sütun)
        $keys = array_keys($rowArray);

        foreach ($kmColumns as $km) {
            // Sütun adını tap (məsələn: 36000, 72000...)
            $key = (string) $km;
            if (isset($rowArray[$key]) && !empty($rowArray[$key])) {
                $say = (int) $rowArray[$key];

                if ($say > 0) {
                    MotorOilDetail::create([
                        'detal_kodu' => $detal_kodu,
                        'detal_adi' => $detal_adi,
                        'olcu_vahidi' => $olcu_vahidi,
                        'miqdar' => $miqdar,
                        'km' => $km,
                        'say' => $say,
                    ]);
                }
            }
        }
    }
}
