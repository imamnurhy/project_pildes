<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tmberkas_aset_tanah extends Model
{
    protected $table = 'tmberkas_aset_tanah';
    protected $guarded = [];
    protected $dates = ['tgl_berakhir_hak'];

    public function tmberkas()
    {
        return $this->belongsTo(Tmberkas::class);
    }
}
