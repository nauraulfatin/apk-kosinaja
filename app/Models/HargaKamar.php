<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HargaKamar extends Model { protected $table='harga_kamars'; protected $primaryKey='id_harga_kamar'; protected $fillable=['id_kamar','harga','isactive','id_periode']; protected $casts=['isactive'=>'boolean','harga'=>'decimal:2']; public function kamar(){return $this->belongsTo(KamarKost::class,'id_kamar');} public function periode(){return $this->belongsTo(PeriodePenagihan::class,'id_periode', 'id_penagihan');} }
