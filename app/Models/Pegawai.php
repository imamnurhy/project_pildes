<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'nik',
        'n_pegawai',
        'telp',
        'alamat',
        't_lahir',
        'd_lahir',
        'jk',
        'rw',
        'kelurahan_id',
        'foto',
        'user_id'
    ];
}
