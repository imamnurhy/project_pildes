<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tm_master_aset extends Model
{
    protected $table = 'tmmaster_asset';

    public function tmJenisAset()
    {
        return $this->belongsTo(Tmjenis_aset::class, 'id_jenis_asset');
    }

    public function tmJenisAsetRincian()
    {
        return $this->belongsTo(Tmjenis_aset_rincian::class, 'id_rincian_jenis_asset');
    }
}
