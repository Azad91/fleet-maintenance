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
        'miqdar',
        'olcu_vahidi',
        'qiymet', // vahid qiyməti (1 ədəd, 1 litr, 1 metr)
    ];

    // Cəmi qiyməti hesabla
    public function getTotalPriceAttribute()
    {
        return $this->miqdar * $this->qiymet;
    }
}
