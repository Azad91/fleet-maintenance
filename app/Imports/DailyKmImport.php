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
        foreach ($rows as $row) {
            // PLAKA NO - ni indeks 3 - dən götür
            $plaka = $row[3] ?? null;
            if (!$plaka) {
                continue;
            }

            // Avtobusu tap
            $bus = Bus::where('dqn', $plaka)->first();
            if (!$bus) {
                \Log::info('Bus tapılmadı: ' . $plaka);
                continue;
            }

            // Tarixləri və KM - ləri oxu
            // Excel - də hər gün üçün: GÜZERGAH (indeks), YAKIT MİKTARI (indeks+1), KM (indeks+2), YAPILAN KM (indeks+3)
            // Tarixlər başlıq sətirində: 06.12.2021, 07.12.2021, 08.12.2021
            // Bunlar $row - da açar kimi gəlir, amma biz onları indekslə oxuyaq

            // 3 gün var: 06.12.2021, 07.12.2021, 08.12.2021
            $dates = ['06.12.2021', '07.12.2021', '08.12.2021'];
            $kmIndices = [6, 10, 14]; // KM sütunlarının indeksləri

            foreach ($dates as $index => $dateStr) {
                try {
                    $tarix = Carbon::createFromFormat('d.m.Y', $dateStr)->format('Y-m-d');
                } catch (\Exception $e) {
                    continue;
                }

                $kmIndex = $kmIndices[$index];
                $km = (int) ($row[$kmIndex] ?? 0);

                if ($km > 0) {
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
