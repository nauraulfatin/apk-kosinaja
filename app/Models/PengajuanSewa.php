<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSewa extends Model
{
    protected $table = 'pengajuan_sewas';

    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [

        'id_user',

        'id_kamar',

        'id_harga_kamar',

        'tanggal_masuk',

        'tanggal_keluar',

        'status'

    ];

    protected $casts = [

        'tanggal_masuk' => 'date',

        'tanggal_keluar' => 'date'

    ];

    /*
    |--------------------------------------------------------------------------
    | USER
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
    | KAMAR
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
    | HARGA KAMAR
    |--------------------------------------------------------------------------
    */

    public function hargaKamar()
    {
        return $this->belongsTo(
            HargaKamar::class,
            'id_harga_kamar',
            'id_harga_kamar'
        );
    }
}