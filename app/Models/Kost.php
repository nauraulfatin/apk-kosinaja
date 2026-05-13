<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    protected $fillable = [

        'nama_kost',

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
}