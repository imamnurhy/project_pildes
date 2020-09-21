<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tm_penghasilan_aset extends Model
{
    protected $fillable = ['tmmaster_aset_id', 'n_aset', 'tgl_pendapatan', 'tahun', 'nilai'];

    public function tmMasterAset()
    {
        return $this->belongsTo(Tm_master_aset::class, 'tmmaster_aset_id');
    }
}
