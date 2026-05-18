<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';
    protected $fillable = [

        'nama_fasilitas'

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KAMAR
    |--------------------------------------------------------------------------
    */

    public function kamars()
    {
        return $this->belongsToMany(

            KamarKost::class,

            'fasilitas_kamars',

            'id_fasilitas',

            'id_kamar'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KOST
    |--------------------------------------------------------------------------
    */

    public function kosts()
    {
        return $this->belongsToMany(

            Kost::class,

            'fasilitas_kost',

            'id_fasilitas',

            'id_kost'

        );
    }
}