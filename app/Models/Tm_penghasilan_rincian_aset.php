<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tm_penghasilan_rincian_aset extends Model
{
    protected $fillable = [
        'tm_penghasilan_aset_id',
        'no_index',
        'n_prolehan',
        'klasifikasi',
        'dinas',
        'n_kontrak',
        'pdn',
    ];

    public function tmPenghasilanAset()
    {
        return $this->belongsTo(Tm_penghasilan_aset::class);
    }
}
