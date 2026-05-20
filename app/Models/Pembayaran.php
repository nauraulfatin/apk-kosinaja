<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $primaryKey = 'id_pembayaran';
    public $incrementing = true; // pastikan ini true
protected $keyType = 'int';

    protected $fillable = [

        'id_tagihan',
        'nominal_pembayaran',
        'tanggal_bayar',
        'bukti_bayar',
        'status_validasi',

    ];

    protected $casts = [

        'tanggal_bayar' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function tagihan()
    {
        return $this->belongsTo(

            Tagihan::class,

            'id_tagihan',

            'id_tagihan'

        );
    }
}