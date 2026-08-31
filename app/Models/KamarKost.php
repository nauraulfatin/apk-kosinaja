<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KamarKost extends Model
{
    protected $table = 'kamar_kosts';

    protected $primaryKey = 'id_kamar';

    protected $fillable = [
        'id_kost',
        'nama_kamar',
        'nomor_kamar',
        'ukuran_kamar',
        'foto_kamar',
    ];

    protected $casts = [
        'foto_kamar' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KOST
    |--------------------------------------------------------------------------
    */
    public function kost()
    {
        return $this->belongsTo(
            Kost::class,
            'id_kost'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI FASILITAS
    |--------------------------------------------------------------------------
    */
    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            'fasilitas_kamars',
            'id_kamar',
            'id_fasilitas'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI HARGA KAMAR
    |--------------------------------------------------------------------------
    */
    public function hargaKamars()
    {
        return $this->hasMany(
            HargaKamar::class,
            'id_kamar'
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
            'id_kamar',
            'id_kamar'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI RIWAYAT HUNIAN
    |--------------------------------------------------------------------------
    */
    public function riwayatHunian()
    {
        return $this->hasMany(
            RiwayatHunian::class,
            'id_kamar',
            'id_kamar'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS KAMAR OTOMATIS
    |--------------------------------------------------------------------------
    |
    | RiwayatHunian.status menjadi satu-satunya sumber kebenaran status kamar.
    | Jika ada riwayat hunian berstatus "aktif", kamar dianggap "terisi".
    | Selain itu kamar dianggap "kosong".
    |
    | Accessor ini sengaja bernama "status" supaya kode Blade lama seperti
    | $kamar->status tetap bekerja tanpa membaca kolom status lama di database.
    |
    */
    public function getStatusAttribute($value): string
    {
        if ($this->relationLoaded('riwayatHunian')) {
            $terisi = $this->riwayatHunian->contains(
                fn (RiwayatHunian $riwayat) => $riwayat->status === 'aktif'
            );
        } else {
            $terisi = $this->riwayatHunian()
                ->where('status', 'aktif')
                ->exists();
        }

        return $terisi ? 'terisi' : 'kosong';
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS LABEL
    |--------------------------------------------------------------------------
    |
    | Tetap disediakan agar kode yang sudah memakai $kamar->status_label
    | juga menghasilkan nilai yang sama persis.
    |
    */
    public function getStatusLabelAttribute(): string
    {
        return $this->status;
    }
}
