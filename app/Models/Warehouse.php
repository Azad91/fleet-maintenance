<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'kod',
        'ad',
        'kateqoriya',
        'olcu_vahidi',
        'miqdar',
        'minimum_miqdar',
        'qiymet',
        'tedarikci',
        'qeyd',
    ];

    protected $casts = [
        'miqdar' => 'integer',
        'minimum_miqdar' => 'integer',
        'qiymet' => 'decimal:2',
    ];

    // ==================== ACCESSORS ====================
    public function getTotalPriceAttribute()
    {
        return $this->miqdar * $this->qiymet;
    }

    public function getStatusAttribute()
    {
        if ($this->miqdar <= 0) {
            return 'empty';
        } elseif ($this->miqdar <= $this->minimum_miqdar) {
            return 'low';
        }
        return 'normal';
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'empty' => '🔴 Bitib',
            'low' => '🟡 Tükənir',
            default => '🟢 Normal',
        };
    }

    // ==================== SCOPES ====================
    public function scopeLowStock($query)
    {
        return $query->whereColumn('miqdar', '<=', 'minimum_miqdar');
    }

    public function scopeEmptyStock($query)
    {
        return $query->where('miqdar', 0);
    }
}
