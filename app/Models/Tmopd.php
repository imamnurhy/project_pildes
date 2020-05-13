<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmopd extends Model
{
    protected $guarded = [];

    public function tmkategoris()
    {
        return $this->belongsTo(Tmkategori::class, 'tmkategori_id');
    }
}
