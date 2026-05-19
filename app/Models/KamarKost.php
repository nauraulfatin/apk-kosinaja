<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\RiwayatHunian;

class KamarKost extends Model { protected $table='kamar_kosts'; protected $primaryKey='id_kamar'; protected $fillable=['id_kost','nama_kamar','nomor_kamar','ukuran_kamar','foto_kamar','status']; protected $casts = [

    'foto_kamar' => 'array',

];
public function kost(){return $this->belongsTo(Kost::class,'id_kost');} public function fasilitas(){return $this->belongsToMany(Fasilitas::class,'fasilitas_kamars','id_kamar','id_fasilitas');} public function hargaKamars(){return $this->hasMany(HargaKamar::class,'id_kamar');}

/*
|--------------------------------------------------------------------------
| RIWAYAT HUNIAN
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



}