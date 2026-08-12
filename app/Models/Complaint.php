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
        'bildirilme_tarix',
        'bildirilme_saat',
        'is_baslama_tarix',
        'is_baslama_saat',
        'is_bitme_tarix',
        'is_bitme_saat',
        'status',
        'detallar',
        'km',
        'qeyd',
        'kim_is_gorub',
    ];

    protected $casts = [
        'bildirilme_tarix' => 'date',
        'is_baslama_tarix' => 'date',
        'is_bitme_tarix' => 'date',
        'detallar' => 'array',
        'km' => 'integer',
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
