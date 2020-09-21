<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmjenis_aset_rincian extends Model
{
    protected $guarded = [];

    public function tmJenisAset()
    {
        return $this->belongsTo(Tmjenis_aset::class, 'tmjenis_aset_id');
    }
}
