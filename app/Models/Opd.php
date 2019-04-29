<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    protected $fillable = ['kode', 'n_opd', 'initial', 'rumpun_id'];

    public function rumpun()
    {
        return $this->belongsTo(Rumpun::class);
    }

    public function unitkerjas()
    {
        return $this->hasMany(Unitkerja::class);
    }
}
