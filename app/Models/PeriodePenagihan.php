<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodePenagihan extends Model
{
    protected $table = 'periode_penagihans';
    protected $primaryKey = 'id_periode';
    protected $fillable = ['periode_penagihan', 'jumlah_interval', 'satuan_interval'];

    public function getLabelLengkapAttribute(): string
    {
        return $this->periode_penagihan.' - setiap '.$this->jumlah_interval.' '.$this->satuan_interval;
    }
}
