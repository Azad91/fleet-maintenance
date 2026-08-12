<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
    'bus_id',
    'yer',
    'surucu_adi',
    'shikayet',
    'sikayet_tipi',
    'tarix',              // SADƏC TARİX
    'status',
    'detallar',
    'km',
    'kim_is_gorub',
    'service_template_id',
    'service_km',
    ];

    protected $casts = [
        'tarix' => 'date',
        'detallar' => 'array',
        'km' => 'integer',
        'service_km' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    // ==================== SCOPES ====================
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeYer($query, $yer)
    {
        return $query->where('yer', $yer);
    }
}
