<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Kost extends Model { protected $fillable=['nama_kost','alamat','deskripsi','foto_kost','id_user']; public function user(){return $this->belongsTo(User::class,'id_user');} public function kamars(){return $this->hasMany(KamarKost::class,'id_kost');} }
