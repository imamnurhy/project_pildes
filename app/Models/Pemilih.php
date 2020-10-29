<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Pemilih extends Model
{
    protected $fillable = [
        'nik',
        'n_pemilih',
        'telp',
        't_lahir',
        'd_lahir',
        'jk',
        'rt',
        'rw',
        'alamat',
        'user_id',
        'foto'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = Auth::user()->id;
            $model->rt = Auth::user()->pegawai->rt;
            $model->rw = Auth::user()->pegawai->rw;
        });
        static::updating(function ($model) {
            $model->user_id = Auth::user()->id;
        });
    }
}
