<?php

namespace App\Imports;

use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class WarehouseImport implements OnEachRow, WithHeadingRow, WithValidation
{
    public function onRow(Row $row)
    {
        $rowArray = $row->toArray();

        $warehouse = Warehouse::where('kod', $rowArray['kod'])->first();

        if ($warehouse) {
            // Mövcuddursa - miqdarı artır, qiyməti yenilə (vahid qiyməti)
            $warehouse->update([
                'miqdar' => $warehouse->miqdar + ($rowArray['miqdar'] ?? 0),
                'qiymet' => $rowArray['qiymet'] ?? $warehouse->qiymet, // Vahid qiyməti
                'ad' => $rowArray['ad'] ?? $warehouse->ad,
                'olcu_vahidi' => $rowArray['olcu_vahidi'] ?? $warehouse->olcu_vahidi,
            ]);
        } else {
            Warehouse::create([
                'kod' => $rowArray['kod'],
                'ad' => $rowArray['ad'],
                'miqdar' => $rowArray['miqdar'] ?? 0,
                'olcu_vahidi' => $rowArray['olcu_vahidi'] ?? null,
                'qiymet' => $rowArray['qiymet'] ?? 0, // Vahid qiyməti
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'kod' => 'required',
            'ad' => 'required',
        ];
    }
}
