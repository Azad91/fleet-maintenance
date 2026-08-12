<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusServiceHistory extends Model
{
    use HasFactory;

    protected $fillable = ['bus_id', 'service_template_id', 'km', 'tarix'];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function serviceTemplate()
    {
        return $this->belongsTo(ServiceTemplate::class);
    }
}
