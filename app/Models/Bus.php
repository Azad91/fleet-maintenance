<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
    'xett_no',
    'dqn',
    'shikayet',
    'tarix',           // SADƏC TARİX QALDI
    'surucu_adi',
    'detallar',
    'aktiv',
    'km',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
        'tarix' => 'date',       // <--- BU VAR
        'detallar' => 'array',
        'km' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function dailyKms()
    {
        return $this->hasMany(DailyKm::class);
    }

    // ==================== SCOPES ====================
    public function scopeActive($query)
    {
        return $query->where('aktiv', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('aktiv', false);
    }
}
