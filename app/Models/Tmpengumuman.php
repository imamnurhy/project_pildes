<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmpengumuman extends Model
{
    protected $table = 'tmpengumumans';
    protected $fillable = ['n_pengumuman', 'ket', 'c_status', 'tgl'];
}
