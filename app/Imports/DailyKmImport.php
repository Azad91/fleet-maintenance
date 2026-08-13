<?php

namespace App\Imports;

use App\Models\Bus;
use App\Models\DailyKm;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Collection;

class DailyKmImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    public function collection(Collection $rows)
    {
        // 01.01.2026 - dan bugünə qədər BÜTÜN GÜNLƏR
        $startDate = Carbon::createFromDate(2026, 1, 1);
        $endDate = Carbon::now();

        $dates = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // KM indeksləri (hər gün üçün bir KM sütunu)
        // Əgər Excel - də 100 gün varsa, 100 KM sütunu olacaq
        // İndekslər: 6, 10, 14, 18, 22, ... (hər 4 sütundan bir)
        $kmIndices = [];
        for ($i = 0; $i < count($dates); $i++) {
            $kmIndices[] = 6 + ($i * 4); // 6, 10, 14, 18, 22, ...
        }

        foreach ($rows as $row) {
            // PLAKA NO - nu indeks 3 - dən götür
            $plaka = $row[3] ?? null;
            if (!$plaka) {
                continue;
            }

            $bus = Bus::where('dqn', $plaka)->first();
            if (!$bus) {
                continue;
            }

            // Hər gün üçün KM dəyərini oxu
            foreach ($kmIndices as $index => $kmIndex) {
                // Əgər sütun mövcuddursa
                if (!isset($row[$kmIndex])) {
                    continue;
                }

                $km = (int) ($row[$kmIndex] ?? 0);
                $tarix = $dates[$index] ?? null;

                if ($km > 0 && $tarix) {
                    DailyKm::updateOrCreate(
                        [
                            'bus_id' => $bus->id,
                            'tarix' => $tarix,
                        ],
                        [
                            'km' => $km,
                        ]
                    );
                }
            }

            // Avtobusun cari km - ni yenilə
            $latestKm = DailyKm::where('bus_id', $bus->id)
                ->orderBy('tarix', 'desc')
                ->first();

            if ($latestKm) {
                $bus->km = $latestKm->km;
                $bus->tarix = $latestKm->tarix;
                $bus->save();
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
