<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_tagihan',
        'nominal_pembayaran',
        'tanggal_bayar',
        'bukti_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function tagihan()
    {
        return $this->belongsTo(
            Tagihan::class,
            'id_tagihan',
            'id_tagihan'
        );
    }
}