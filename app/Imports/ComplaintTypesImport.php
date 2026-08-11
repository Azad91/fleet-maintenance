<?php

namespace App\Imports;

use App\Models\ComplaintType;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Row;

class ComplaintTypesImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function onRow(Row $row)
    {
        $rowArray = $row->toArray();

        if (empty($rowArray['name'])) {
            return;
        }

        ComplaintType::updateOrCreate(
            ['name' => $rowArray['name']]
        );
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
