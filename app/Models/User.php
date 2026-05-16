<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['username', 'nik', 'nama', 'password', 'no_hp', 'role', 'status', 'must_change_password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['must_change_password' => 'boolean', 'password' => 'hashed'];

    public function kost() { return $this->hasOne(Kost::class, 'id_user'); }
    public function tagihans() { return $this->hasMany(Tagihan::class, 'id_user'); }
    public function aduan() { return $this->hasMany(Aduan::class, 'id_user');}
}
