<?php

namespace App\Imports;

use App\Models\Bus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BusesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return Bus::updateOrCreate(
            ['dqn' => $row['dqn']],
            [
                'xett_no' => $row['xett_no'] ?? null,
                'km' => $row['km'] ?? null,   // YENİ
            ]
        );
    }

    public function rules(): array
    {
        return [
            'dqn' => 'required',
            'xett_no' => 'required',
        ];
    }
}
