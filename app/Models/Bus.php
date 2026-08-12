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
        'bildirilme_tarix',
        'bildirilme_saat',
        'is_baslama_tarix',
        'is_baslama_saat',
        'is_bitme_tarix',
        'is_bitme_saat',
        'surucu_adi',
        'detallar',
        'aktiv',
        'km',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
        'bildirilme_tarix' => 'date',
        'is_baslama_tarix' => 'date',
        'is_bitme_tarix' => 'date',
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
