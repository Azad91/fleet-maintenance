<?php

namespace App\Imports;

use App\Models\DailyKmRecord;
use App\Models\Bus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DailyKmRecordsImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    public function model(array $row)
    {
        $dqn = trim($row[3] ?? '');
        if (empty($dqn)) {
            return null;
        }

        $bus = Bus::where('dqn', $dqn)->first();
        if (!$bus) {
            return null;
        }

        foreach ($row as $key => $value) {
            if (empty($value) || (int)$value == 0) {
                continue;
            }

            try {
                // Tarixi çevir
                if (is_numeric($key)) {
                    $tarix = Carbon::instance(Date::excelToDateTimeObject($key));
                } else {
                    // Həm dd.mm.yyyy, həm də yyyy-mm-dd formatlarını dəstəklə
                    $tarix = Carbon::parse($key);
                }

                $km = (int) $value;

                if ($km > 0) {
                    DailyKmRecord::updateOrCreate(
                        ['bus_id' => $bus->id, 'tarix' => $tarix->toDateString()],
                        ['km' => $km]
                    );
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return null;
    }

    public function chunkSize(): int
    {
        return 200; // Hər dəfə 200 sətir oxu
    }

    public function batchSize(): int
    {
        return 100; // Hər dəfə 100 sətir yaz
    }
}
