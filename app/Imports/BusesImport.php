<?php

namespace App\Imports;

use App\Models\Bus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class BusesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows
{
    use SkipsFailures;

    public function model(array $row)
    {
        // dqn boşdursa, keç
        if (empty($row['dqn'])) {
            return null;
        }

        return Bus::updateOrCreate(
            ['dqn' => $row['dqn']],
            [
                'xett_no' => $row['xett_no'] ?? null,
                'km' => $row['km'] ?? null,
                'tarix' => now()->format('Y-m-d'),
            ]
        );
    }

    public function rules(): array
    {
        return [
            'dqn' => 'required',
            'xett_no' => 'nullable',
            'km' => 'nullable|integer|min:0',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'dqn.required' => 'DQN boş buraxıla bilməz!',
        ];
    }
}
