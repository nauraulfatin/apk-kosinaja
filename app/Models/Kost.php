<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kost extends Model
{
    protected $fillable = [

        'nama_kost',
        'kode_undangan',

        'alamat',

        'deskripsi',

        'foto_kost',

        'lokasi',

        'id_user'

    ];

    /*
    |--------------------------------------------------------------------------
    | CAST JSON FOTO
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'foto_kost' => 'array',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION KAMAR
    |--------------------------------------------------------------------------
    */

    public function kamars()
    {
        return $this->hasMany(
            KamarKost::class,
            'id_kost'
        );
    }

    /*
|--------------------------------------------------------------------------
| RELASI FASILITAS KOST
|--------------------------------------------------------------------------
*/

public function fasilitas()
{
    return $this->belongsToMany(

        Fasilitas::class,

        'fasilitas_kost',

        'id_kost',

        'id_fasilitas'

    );
}

/*
|--------------------------------------------------------------------------
| AUTO GENERATE KODE UNDANGAN
|--------------------------------------------------------------------------
*/

protected static function booted()
{
    static::creating(function ($kost) {

        do {

            $kode = strtoupper(

                Str::random(8)

            );

        } while (

            self::where(
                'kode_undangan',
                $kode
            )->exists()

        );

        $kost->kode_undangan =
            $kode;

    });
}
}