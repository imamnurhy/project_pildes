<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trlelang_syarat extends Model
{
    protected $fillable = ['tmlelang_id', 'tmsyarat_id', 'c_status', 'no_urut'];

    public function tmlelang()
    {
        return $this->belongsTo(Tmlelang::class);
    }

    public function tmsyarat()
    {
        return $this->belongsTo(Tmsyarat::class);
    }
}
