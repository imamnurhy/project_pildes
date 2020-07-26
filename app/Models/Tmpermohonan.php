<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmpermohonan extends Model
{
    protected $guarded = [];

    public function tmopd()
    {
        return $this->belongsTo(Tmopd::class);
    }
}
