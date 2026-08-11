<?php

namespace App\Imports;

use App\Models\Bus;
use App\Models\DailyKm;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class DailyKmImport implements OnEachRow, WithHeadingRow, WithValidation
{
    public function onRow(Row $row)
    {
        $rowArray = $row->toArray();

        $bus = Bus::where('dqn', $rowArray['dqn'])->first();
        if (!$bus) {
            return;
        }

        DailyKm::updateOrCreate(
            [
                'bus_id' => $bus->id,
                'tarix' => $rowArray['tarix'],
            ],
            [
                'km' => $rowArray['km'],
            ]
        );
    }

    public function rules(): array
    {
        return [
            'dqn' => 'required',
            'tarix' => 'required|date',
            'km' => 'required|integer|min:0',
        ];
    }
}
