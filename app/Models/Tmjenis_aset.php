<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmjenis_aset extends Model
{
    protected $guarded = [];

    public function trpertanyaan_details()
    {
        return $this->belongsTo(Trpertanyaan_detail::class, 'tmjenis_aset_id');
    }

    public function tmpertanyaans()
    {
        return $this->belongsToMany(Tmpertanyaan::class);
    }
}
