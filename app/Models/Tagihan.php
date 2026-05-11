<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihans';

    protected $primaryKey = 'id_tagihan';

    protected $fillable = [
        'id_kamar',
        'id_user',
        'id_harga_kamar',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_jatuh_tempo',
        'status',
        'bukti_bayar',
        'status_bukti',
        'validated_by',
        'validated_at',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'validated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function kamar()
    {
        return $this->belongsTo(
            KamarKost::class,
            'id_kamar'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user'
        );
    }

    public function hargaKamar()
    {
        return $this->belongsTo(
            HargaKamar::class,
            'id_harga_kamar'
        );
    }

    public function pembayaran()
    {
        return $this->hasOne(
            Pembayaran::class,
            'id_tagihan',
            'id_tagihan'
        );
    }

    public function validator()
    {
        return $this->belongsTo(
            User::class,
            'validated_by'
        );
    }
}