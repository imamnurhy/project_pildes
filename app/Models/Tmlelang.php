<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmlelang extends Model
{
    protected $fillable = ['n_lelang', 'ket', 'd_dari', 'd_sampai', 'c_status', 'nilai_sewa', 'jumlah_mobil', 'jumlah_motor', 'luas_lahan', 'foto', 'alamat'];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function trlelang_syarats()
    {
        return $this->hasMany(Trlelang_syarat::class);
    }
}
