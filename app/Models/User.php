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

        /*
        |--------------------------------------------------------------------------
        | REVISI PENGHUNI
        |--------------------------------------------------------------------------
        */

        'id_kost',

        'id_kamar',

        'status_penghuni'

    ];

    protected $hidden = [

        'password',

        'remember_token'

    ];

    protected $casts = [

        'must_change_password' => 'boolean',

        'password' => 'hashed'

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KOST ADMIN
    |--------------------------------------------------------------------------
    */

    public function kost()
    {
        return $this->hasOne(
            Kost::class,
            'id_user'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI TAGIHAN
    |--------------------------------------------------------------------------
    */

    public function tagihans()
    {
        return $this->hasMany(
            Tagihan::class,
            'id_user'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI ADUAN
    |--------------------------------------------------------------------------
    */

    public function aduan()
    {
        return $this->hasMany(
            Aduan::class,
            'id_user'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | KAMAR AKTIF
    |--------------------------------------------------------------------------
    */

    public function kamar()
    {
        return $this->belongsTo(
            KamarKost::class,
            'id_kamar',
            'id_kamar'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | KOST AKTIF
    |--------------------------------------------------------------------------
    */

    public function kostAktif()
    {
        return $this->belongsTo(
            Kost::class,
            'id_kost'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PENGAJUAN SEWA
    |--------------------------------------------------------------------------
    */

    public function pengajuanSewas()
    {
        return $this->hasMany(
            PengajuanSewa::class,
            'id_user'
        );
    }
}