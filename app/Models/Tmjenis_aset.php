<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function getJenisAset()
    {
        return DB::table('tmjenis_asets')
            ->select('tmasets.id as tmaset_id', 'tmjenis_asets.n_jenis_aset', 'tmasets.serial', 'tmmerks.n_merk')
            ->join('tmasets', 'tmjenis_asets.id', 'tmasets.jenis_aset_id')
            ->join('tmmerks', 'tmasets.merk_id', 'tmmerks.id')
            ->get();
    }
}
