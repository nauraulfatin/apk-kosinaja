<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kost extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_kost',
        'kode_undangan',
        'alamat',
        'deskripsi',
        'foto_kost',
        'lokasi',
        'id_user',
    ];

    protected $casts = [
        'foto_kost' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kamars()
    {
        return $this->hasMany(KamarKost::class, 'id_kost');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            'fasilitas_kost',
            'id_kost',
            'id_fasilitas'
        );
    }

    public function aturanKos()
    {
        return $this->hasMany(AturanKos::class, 'kost_id');
    }

    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'kost_id');
    }

    public function riwayatHunians()
    {
        return $this->hasMany(RiwayatHunian::class, 'id_kost');
    }

    protected static function booted()
    {
        static::creating(function (Kost $kost) {
            if ($kost->kode_undangan) {
                return;
            }

            do {
                $kode = strtoupper(Str::random(8));
            } while (self::where('kode_undangan', $kode)->exists());

            $kost->kode_undangan = $kode;
        });
    }
}
