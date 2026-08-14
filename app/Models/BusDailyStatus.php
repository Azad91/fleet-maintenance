<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusDailyStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'tarix',
        'status',
        'qeyd',
    ];

    protected $casts = [
        'tarix' => 'date',
    ];

    // Əlaqə: Bu status hansı avtobusa aiddir?
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
