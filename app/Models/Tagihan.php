<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pembayaran;

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

        /*
        |--------------------------------------------------------------------------
        | STATUS TAGIHAN
        |--------------------------------------------------------------------------
        |
        | pending
        | menunggu_verifikasi
        | ditolak
        | telat
        | lunas
        |
        */

        'status',

        /*
        |--------------------------------------------------------------------------
        | VALIDASI ADMIN
        |--------------------------------------------------------------------------
        */

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
    | RELATION KAMAR
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
    | RELATION HARGA KAMAR
    |--------------------------------------------------------------------------
    */

    public function hargaKamar()
    {
        return $this->belongsTo(

            HargaKamar::class,

            'id_harga_kamar'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION PEMBAYARAN
    |--------------------------------------------------------------------------
    |
    | 1 TAGIHAN
    | BISA PUNYA BANYAK PEMBAYARAN
    | (CICILAN)
    |
    */

    public function pembayaran()
    {
        return $this->hasMany(

            Pembayaran::class,

            'id_tagihan',

            'id_tagihan'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION VALIDATOR
    |--------------------------------------------------------------------------
    */

    public function validator()
    {
        return $this->belongsTo(

            User::class,

            'validated_by'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL SUDAH DIBAYAR
    |--------------------------------------------------------------------------
    */

    public function getTotalDibayarAttribute()
    {
        return $this->pembayaran()

            ->where(

                'status_validasi',

                'diterima'

            )

            ->sum(

                'nominal_pembayaran'

            );
    }

    /*
    |--------------------------------------------------------------------------
    | SISA TAGIHAN
    |--------------------------------------------------------------------------
    */

    public function getSisaTagihanAttribute()
    {
        return max(

            0,

            ($this->hargaKamar?->harga ?? 0)

            -

            $this->total_dibayar

        );
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS LABEL
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute()
    {
        /*
        |--------------------------------------------------------------------------
        | LUNAS
        |--------------------------------------------------------------------------
        */

        if (

            $this->sisa_tagihan <= 0

        ) {

            return 'lunas';
        }

        /*
        |--------------------------------------------------------------------------
        | PEMBAYARAN TERAKHIR
        |--------------------------------------------------------------------------
        */

        $pembayaranTerakhir =

            $this->pembayaran()

                ->latest()

                ->first();

        /*
        |--------------------------------------------------------------------------
        | MENUNGGU VERIFIKASI
        |--------------------------------------------------------------------------
        */

        if (

            $pembayaranTerakhir?->status_validasi === 'menunggu'

        ) {

            return 'menunggu_verifikasi';
        }

        /*
        |--------------------------------------------------------------------------
        | DITOLAK
        |--------------------------------------------------------------------------
        */

        if (

            $pembayaranTerakhir?->status_validasi === 'ditolak'

        ) {

            return 'ditolak';
        }

        /*
        |--------------------------------------------------------------------------
        | TELAT
        |--------------------------------------------------------------------------
        */

        if (

            now()->gt($this->tanggal_jatuh_tempo)

        ) {

            return 'telat';
        }

        /*
        |--------------------------------------------------------------------------
        | DEFAULT
        |--------------------------------------------------------------------------
        */

        return 'pending';
    }
}