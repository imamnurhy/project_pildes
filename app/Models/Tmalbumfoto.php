<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmalbumfoto extends Model
{
    protected $fillable = ['tmalbum_id', 'no_urut', 'img', 'c_status', 'ket'];

    public function album()
    {
        return $this->belongsTo(Tmalbum::class);
    }
}
