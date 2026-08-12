<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ==================== ROLE CHECKS ====================
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isBus()
    {
        return $this->role === 'bus';
    }

    public function isComplaint()
    {
        return $this->role === 'complaint';
    }

    public function isWarehouse()
    {
        return $this->role === 'warehouse';
    }

    public function isDirectorate()
    {
        return $this->role === 'directorate';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function hasAnyRole($roles)
    {
        return in_array($this->role, $roles);
    }
}
