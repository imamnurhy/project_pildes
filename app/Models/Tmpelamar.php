<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Tmpelamar extends Model
{
    protected $fillable = ['panselnas_id', 'c_panselnas', 'd_panselnas', 'n_panselnas', 'c_admin', 'd_admin', 'alasan_tolak', 'd_kesehatan_dari', 'd_kegiatan_sampai', 'd_assesment_dari', 'd_assesment_sampai', 'd_wawancara_dari', 'd_wawancara_sampai', 'd_pengumuman_dari', 'd_pengumuman_sampai', 'admin_panselnas_id', 'n_admin_panselnas_id', 'd_admin_panselnas_id', 'alasan_tolak_admin_panselnas', 'c_tolak_admin', 'c_pemenang'];

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

    public static function pemenang($tmlelang_id)
    {
        // dd($tmlelang_id);

        if ($tmlelang_id != 99) {

            return DB::select("
            SELECT
                tmpelamars.id,
                tmregistrasi_id,
                tmlelang_id,
                c_pemenang,
                tmregistrasis.nama_pl,
                tmregistrasis.n_pr,
                tmlelangs.n_lelang,

                tmpelamars.tmregistrasi_id,
                tmpelamars.tmpelamar_status_id,
                tmpelamars.tmlelang_id,
                tmpelamars.no_pendaftaran,
                tmpelamars.c_admin,
                tmpelamars.c_tolak,
                tmpelamars.penawaran,
                tmpelamars.c_pemenang,
                ( SELECT max( a.c_pemenang ) FROM tmpelamars AS a WHERE a.tmlelang_id = tmlelangs.id AND a.c_pemenang = 1 ) AS status
            FROM
                tmpelamars
                INNER JOIN tmregistrasis ON tmpelamars.tmregistrasi_id = tmregistrasis.id
                INNER JOIN tmlelangs ON tmpelamars.tmlelang_id = tmlelangs.id
                WHERE  tmpelamars.tmpelamar_status_id = 3 AND  tmpelamars.tmlelang_id = $tmlelang_id
        ");
        }

        return DB::select("
            SELECT
                tmpelamars.id,
                tmregistrasi_id,
                tmlelang_id,
                c_pemenang,
                tmregistrasis.nama_pl,
                tmregistrasis.n_pr,
                tmlelangs.n_lelang,

                tmpelamars.tmregistrasi_id,
                tmpelamars.tmpelamar_status_id,
                tmpelamars.tmlelang_id,
                tmpelamars.no_pendaftaran,
                tmpelamars.c_admin,
                tmpelamars.c_tolak,
                tmpelamars.penawaran,
                tmpelamars.c_pemenang,
                ( SELECT max( a.c_pemenang ) FROM tmpelamars AS a WHERE a.tmlelang_id = tmlelangs.id AND a.c_pemenang = 1 ) AS status
            FROM
                tmpelamars
                INNER JOIN tmregistrasis ON tmpelamars.tmregistrasi_id = tmregistrasis.id
                INNER JOIN tmlelangs ON tmpelamars.tmlelang_id = tmlelangs.id
                WHERE  tmpelamars.tmpelamar_status_id = 3
                ORDER BY  tmpelamars.penawaran+0 DESC
        ");
    }
}
