<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorOilDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'detal_kodu',
        'detal_adi',
        'olcu_vahidi',
        'miqdar',
        'km',
        'say',
    ];

    public function getTotalMiqdarAttribute()
    {
        return $this->miqdar * $this->say;
    }
}
