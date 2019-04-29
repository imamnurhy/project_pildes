<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmsyarat extends Model
{
    protected $fillable = ['n_syarat', 'ket'];

    public function trlelang_syarats()
    {
        return $this->hasMany(Trlelang_syarat::class);
    }
}
