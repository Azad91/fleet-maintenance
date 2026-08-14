<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_project',
        'vin',
        'uzunluq',
        'xett_no',
        'dqn',
        'motor_no',
        'km',
        'tarix',
        'aktiv',
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
        return $this->hasMany(DailyKm::class)->orderBy('tarix', 'desc');
    }

    public function getLatestKmAttribute()
    {
        $latest = $this->dailyKms()->orderBy('tarix', 'desc')->first();
        return $latest ? $latest->km : null;
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

    public function dailyStatuses()
    {
        return $this->hasMany(BusDailyStatus::class)->orderBy('tarix', 'desc');
    }

    // Ən son statusu asanlıqla almaq üçün aksessor:
    public function getLatestStatusAttribute()
    {
        return $this->dailyStatuses()->first();
    }
}
