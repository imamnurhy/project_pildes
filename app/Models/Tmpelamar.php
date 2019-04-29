<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmpelamar extends Model
{
    protected $fillable = ['panselnas_id', 'c_panselnas', 'd_panselnas', 'n_panselnas', 'c_admin', 'd_admin', 'alasan_tolak', 'd_kesehatan_dari', 'd_kegiatan_sampai', 'd_assesment_dari', 'd_assesment_sampai', 'd_wawancara_dari', 'd_wawancara_sampai'];

    function tmregistrasi()
    {
        return $this->belongsTo(Tmregistrasi::class);
    }

    function tmlelang()
    {
        return $this->belongsTo(Tmlelang::class);
    }

    function tmpelamar_status()
    {
        return $this->belongsTo(Tmpelamar_status::class);
    }
}
