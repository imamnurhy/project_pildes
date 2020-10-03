<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tm_pembayaran extends Model
{
    protected $fillable = ['pelanggan_id', 'tgl_bayar', 'jml_bayar', 'status'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
