<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trpertanyaan_detail extends Model
{
    protected $guarded = [];

    public function tmpertanyaans()
    {
        return $this->belongsTo(Tmpertanyaan::class, 'id');
    }

    public function tmjenis_asets()
    {
        return $this->belongsTo(Tmjenis_aset::class, 'id');
    }
}
