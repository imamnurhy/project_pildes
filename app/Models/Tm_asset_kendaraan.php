<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tm_asset_kendaraan extends Model
{
    protected $fillable = [
        'no_polisi',
        'no_stnk',
        'merek',
        'nm_pemilik',
        'sumber_barang',
        'nilai',
        'tmmaster_asset_id'
    ];
}
