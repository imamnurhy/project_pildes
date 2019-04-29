<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmagenda extends Model
{
    protected $fillable = ['n_agenda', 'ket', 'c_status', 'd_dari', 'd_sampai'];
}
