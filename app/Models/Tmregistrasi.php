<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmregistrasi extends Model
{
    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }
}
