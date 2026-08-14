<?php

namespace App\Imports;

use App\Models\Bus;
use App\Models\BusDailyStatus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class BusDailyStatusesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Excel sütunları: HAT No, DQN, DURUM
        $hat_no = $row['hat_no'] ?? $row['HAT No'] ?? null;
        $dqn    = $row['dqn'] ?? $row['DQN'] ?? null;
        $durum  = $row['durum'] ?? $row['DURUM'] ?? null;

        if (empty($dqn)) {
            return null;
        }

        // DQN-ə görə avtobusu tap
        $bus = Bus::where('dqn', trim($dqn))->first();

        if (!$bus) {
            return null; // Əgər DQN bazada yoxdursa, keç
        }

        // Əgər HAT No varsa, onu da yoxlaya bilərik (isteğe bağlı)
        // Amma əsas identifikator DQN-dir.

        return BusDailyStatus::updateOrCreate(
            [
                'bus_id' => $bus->id,
                'tarix'  => now()->toDateString(), // Bugünkü tarix
            ],
            [
                'status' => $durum ?? 'MƏLUMAT YOXDUR',
                'qeyd'   => null,
            ]
        );
    }
}
