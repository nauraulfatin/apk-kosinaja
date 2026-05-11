<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KamarKost extends Model { protected $table='kamar_kosts'; protected $primaryKey='id_kamar'; protected $fillable=['id_kost','nama_kamar','nomor_kamar','ukuran_kamar','foto_kamar','status']; public function kost(){return $this->belongsTo(Kost::class,'id_kost');} public function fasilitas(){return $this->belongsToMany(FasilitasKost::class,'fasilitas_kamars','id_kamar','id_fasilitas');} public function hargaKamars(){return $this->hasMany(HargaKamar::class,'id_kamar');} }
