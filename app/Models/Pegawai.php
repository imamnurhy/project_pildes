<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = ['nip', 'n_pegawai', 'telp', 'alamat', 'unitkerja_id', 'tmopd_id', 'user_id', 'nik', 't_lahir', 'd_lahir', 'jk', 'pekerjaan', 'kelurahan_id', 'alamat'];

    public function tmopds()
    {
        return $this->belongsTo(Tmopd::class, 'tmopd_id');
    }
}
