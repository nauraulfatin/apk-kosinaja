<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    protected $table = 'aduan';

    protected $primaryKey = 'id_aduan';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'kost_id',
        'isi_aduan',
        'foto_aduan',
        'tanggapan_admin',
        'status',
        'tanggal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kost()
    {
        return $this->belongsTo(Kost::class, 'kost_id');
    }
}