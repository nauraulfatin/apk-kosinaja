<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodePenagihan extends Model
{
    protected $table = 'periode_penagihans';

    protected $primaryKey = 'id_penagihan';

    protected $fillable = [
        'periode_penagihan',
        'jumlah_interval',
        'satuan_interval',
    ];

    protected $casts = [
        'jumlah_interval' => 'integer',
    ];

    public function hargaKamars()
    {
        return $this->hasMany(
            HargaKamar::class,
            'id_periode',
            'id_penagihan'
        );
    }

    public function getLabelLengkapAttribute(): string
    {
        return $this->periode_penagihan
            . ' - setiap '
            . $this->jumlah_interval
            . ' '
            . $this->satuan_interval;
    }
}
