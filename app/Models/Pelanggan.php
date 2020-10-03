<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = ['n_pelanggan', 'no_hp', 'tgl_daftar', 'layanan_id'];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function tmPembayaran()
    {
        return $this->hasMany(Tm_pembayaran::class);
    }
}
