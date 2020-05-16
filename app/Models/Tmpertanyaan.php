<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmpertanyaan extends Model
{
    protected $guarded = [];

    public function tmjenis_asets()
    {
        return $this->belongsToMany(Tmjenis_aset::class);
    }
}
