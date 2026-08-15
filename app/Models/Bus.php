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
        'tarix' => 'date',
        'detallar' => 'array',
        'km' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function dailyKmRecords()
    {
        return $this->hasMany(DailyKmRecord::class)->orderBy('tarix', 'desc');
    }

    public function dailyStatuses()
    {
        return $this->hasMany(BusDailyStatus::class)->orderBy('tarix', 'desc');
    }

    // ==================== ƏN SON MƏLUMATLARI ALMAQ ÜÇÜN ====================
    public function latestKmRecord()
    {
        return $this->hasOne(DailyKmRecord::class)->latest('tarix');
    }

    // Ən son KM dəyərini almaq üçün aksessor
    public function getLatestKmAttribute()
    {
        return $this->latestKmRecord?->km;
    }

    // Ən son statusu almaq üçün aksessor
    public function getLatestStatusAttribute()
    {
        return $this->dailyStatuses()->first();
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
