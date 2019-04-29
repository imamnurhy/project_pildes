<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmalbum extends Model
{
    protected $fillable = ['n_album', 'ket', 'c_status'];

    public function tmalbumfotos()
    {
        return $this->hasMany(Tmalbumfoto::class);
    }
}
