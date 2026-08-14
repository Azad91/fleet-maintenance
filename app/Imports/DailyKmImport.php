<?php

namespace App\Imports;

use App\Models\DailyKmRecord;
use App\Models\Bus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DailyKmRecordsImport implements ToModel, WithHeadingRow
{
    public function headingRow(): int
    {
        return 1;
    }

    public function model(array $row)
    {
        // DQN - İndi 'avtobus_dqn' açarı ilə gəlir
        $dqn = trim($row['avtobus_dqn'] ?? '');
        if (empty($dqn)) {
            return null;
        }

        $bus = Bus::where('dqn', $dqn)->first();
        if (!$bus) {
            return null;
        }

        // Bütün sütunları yoxla
        foreach ($row as $key => $value) {
            // Əgər açar rəqəmdirsə və dəyər 0-dan böyükdürsə
            if (is_numeric($key) && $value > 0) {
                // Excel rəqəmini tarixə çevir
                $tarix = Carbon::instance(Date::excelToDateTimeObject($key))->toDateString();

                DailyKmRecord::updateOrCreate(
                    ['bus_id' => $bus->id, 'tarix' => $tarix],
                    ['km' => (int) $value]
                );
            }
        }

        return null;
    }
}
