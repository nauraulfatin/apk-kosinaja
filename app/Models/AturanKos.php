<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AturanKos extends Model
{
    protected $table = 'peraturans';

    protected $fillable = [
        'kost_id',
        'judul',
        'isi'
    ];
}