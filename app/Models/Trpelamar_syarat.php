<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trpelamar_syarat extends Model
{

    function tmsyarat()
    {
        return $this->belongsTo(Tmsyarat::class);
    }
}
