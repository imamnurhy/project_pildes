<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unitkerja extends Model
{
    protected $fillable = ['n_unitkerja', 'initial', 'opd_id'];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
