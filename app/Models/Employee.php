<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad',
        'soyad',
        'vezifesi',
        'aktiv',
        'qeyd',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
    ];

    // ==================== ACCESSORS ====================
    public function getFullNameAttribute()
    {
        if (empty($this->soyad)) {
            return $this->ad;
        }
        return $this->ad . ' ' . $this->soyad;
    }

    public function getFullNameWithPositionAttribute()
    {
        $name = $this->ad;
        if (!empty($this->soyad)) {
            $name .= ' ' . $this->soyad;
        }
        return $name . ' (' . $this->vezifesi . ')';
    }

    // ==================== RELATIONSHIPS ====================
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    // ==================== SCOPES ====================
    public function scopeActive($query)
    {
        return $query->where('aktiv', true);
    }
}
