<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tm_penghasilan_aset extends Model
{
    protected $guarded = [];

    public function tmMasterAset()
    {
        return $this->belongsTo(Tm_master_aset::class, 'tmmaster_aset_id');
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
