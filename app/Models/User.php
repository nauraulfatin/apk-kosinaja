<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'nik',
        'nama',
        'password',
        'no_hp',
        'role',
        'status',
        'must_change_password',
        'created_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'must_change_password' => 'boolean',
        'password' => 'hashed',
    ];

    public function kost()
    {
        return $this->hasOne(Kost::class, 'id_user');
    }

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'id_user');
    }

    public function aduan()
    {
        return $this->hasMany(Aduan::class, 'id_user');
    }

    public function riwayatHunian()
    {
        return $this->hasMany(RiwayatHunian::class, 'id_user');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }
}
