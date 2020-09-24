<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tm_pendapatan extends Model
{
    protected $fillable = [
        'pegawai_id',
        'n_pegawai',
        'n_aset',
        'tmmaster_aset_id',
        'nilai',
        'tgl_pendapatan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function tmmasterAset()
    {
        return $this->belongsTo(Tm_master_aset::class);
    }
}
