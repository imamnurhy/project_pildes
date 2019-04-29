<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = ['nip', 'n_pegawai', 'telp', 'alamat', 'unitkerja_id', 'opd_id', 'user_id', 'nik', 't_lahir', 'd_lahir', 'jk', 'pekerjaan', 'kelurahan_id', 'alamat', 'golongan_id', 'tmt_golongan', 'eselon_id', 'tmt_eselon', 'jabatan', 'instansi'];

    public function unitkerja()
    {
        return $this->belongsTo(Unitkerja::class);
    }
    
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }
}
