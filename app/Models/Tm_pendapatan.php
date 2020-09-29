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
        'tgl_pendapatan',
        'tmjenis_aset_id',
        'tmjenis_aset_rincian_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function tmmasterAset()
    {
        return $this->belongsTo(Tm_master_aset::class);
    }

    public function tmJenisAset()
    {
        return $this->belongsTo(Tmjenis_aset::class, 'tmjenis_aset_id');
    }

    public function tmJenisAsetRincian()
    {
        return $this->belongsTo(Tmjenis_aset_rincian::class, 'tmjenis_aset_rincian_id');
    }
}
