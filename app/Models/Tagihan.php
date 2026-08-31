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

        /*
        |--------------------------------------------------------------------------
        | STATUS FINANSIAL TAGIHAN
        |--------------------------------------------------------------------------
        |
        | Kolom status hanya menyimpan keadaan finansial tagihan:
        |
        | pending = belum lunas dan belum lewat jatuh tempo
        | telat   = belum lunas dan sudah lewat jatuh tempo
        | lunas   = total pembayaran yang diterima >= nominal tagihan
        |
        | Status "menunggu_verifikasi" dan "ditolak" BUKAN status finansial
        | tagihan. Keduanya berasal dari status_validasi pada pembayaran.
        |
        */
        'status',

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
            'id_kamar',
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
        return $this->hasMany(
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

    /*
    |--------------------------------------------------------------------------
    | TOTAL PEMBAYARAN YANG SUDAH DITERIMA
    |--------------------------------------------------------------------------
    */

    public function getTotalDibayarAttribute(): float
    {
        if ($this->relationLoaded('pembayaran')) {
            return (float) $this->pembayaran
                ->where('status_validasi', 'diterima')
                ->sum('nominal_pembayaran');
        }

        return (float) $this->pembayaran()
            ->where('status_validasi', 'diterima')
            ->sum('nominal_pembayaran');
    }

    /*
    |--------------------------------------------------------------------------
    | NOMINAL TAGIHAN
    |--------------------------------------------------------------------------
    */

    public function getTotalTagihanAttribute(): float
    {
        return (float) ($this->hargaKamar?->harga ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | SISA TAGIHAN
    |--------------------------------------------------------------------------
    */

    public function getSisaTagihanAttribute(): float
    {
        return max(
            0,
            $this->total_tagihan - $this->total_dibayar
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN TERAKHIR
    |--------------------------------------------------------------------------
    */

    public function getPembayaranTerakhirAttribute(): ?Pembayaran
    {
        if ($this->relationLoaded('pembayaran')) {
            return $this->pembayaran
                ->sortByDesc('id_pembayaran')
                ->first();
        }

        return $this->pembayaran()
            ->latest('id_pembayaran')
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG STATUS FINANSIAL
    |--------------------------------------------------------------------------
    |
    | Hanya menghasilkan: pending, telat, lunas.
    |
    */

    public function calculateFinancialStatus(): string
    {
        if ($this->sisa_tagihan <= 0) {
            return 'lunas';
        }

        if (
            $this->tanggal_jatuh_tempo &&
            now()->startOfDay()->gt($this->tanggal_jatuh_tempo->copy()->startOfDay())
        ) {
            return 'telat';
        }

        return 'pending';
    }

    /*
    |--------------------------------------------------------------------------
    | SINKRONKAN STATUS FINANSIAL KE DATABASE
    |--------------------------------------------------------------------------
    |
    | Dipanggil setelah pembayaran berubah atau saat halaman tagihan dibuka.
    |
    */

    public function syncFinancialStatus(): string
    {
        $newStatus = $this->calculateFinancialStatus();

        if ($this->getRawOriginal('status') !== $newStatus) {
            $this->forceFill([
                'status' => $newStatus,
            ])->saveQuietly();
        }

        // Pastikan nilai pada instance model ikut terbaru.
        $this->setAttribute('status', $newStatus);

        return $newStatus;
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS LABEL UNTUK UI
    |--------------------------------------------------------------------------
    |
    | Status UI merupakan gabungan dari:
    | - status finansial tagihan
    | - status validasi pembayaran terakhir
    |
    | Urutan prioritas:
    | 1. lunas
    | 2. menunggu_verifikasi
    | 3. ditolak
    | 4. telat
    | 5. pending
    |
    */

    public function getStatusLabelAttribute(): string
    {
        if ($this->sisa_tagihan <= 0) {
            return 'lunas';
        }

        $pembayaranTerakhir = $this->pembayaran_terakhir;

        if ($pembayaranTerakhir?->status_validasi === 'menunggu') {
            return 'menunggu_verifikasi';
        }

        if ($pembayaranTerakhir?->status_validasi === 'ditolak') {
            return 'ditolak';
        }

        return $this->calculateFinancialStatus();
    }
}
