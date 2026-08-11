<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyKm extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'tarix',
        'km',
    ];

    protected $casts = [
        'tarix' => 'date',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
