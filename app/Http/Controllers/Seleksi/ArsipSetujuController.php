<?php

namespace App\Http\Controllers\Seleksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Auth;

use App\Models\Tmpelamar;
use App\Models\Trpelamar_syarat;
use App\Models\Tmpelamar_status;
use App\Models\Tmregistrasi;
use App\Models\Golongan;
use App\Models\Eselon;
use App\Models\Tmlelang;

class ArsipSetujuController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tmlelangs = Tmlelang::select('id', 'n_lelang')->where('c_status', 1)->get();
        return view('seleksi.arsipSetuju.table', compact('tmlelangs'));
    }

    public function api(Request $request)
    {

        // $tmpelamar2 = Tmpelamar::select('tmpelamars.id', 'tmpelamars.tmregistrasi_id', 'tmpelamars.tmpelamar_status_id', 'tmpelamars.tmlelang_id', 'tmpelamars.no_pendaftaran', 'tmpelamars.c_admin', 'tmpelamars.c_tolak', 'tmpelamars.penawaran', 'tmpelamars.c_pemenang')->with(['tmregistrasi:id,nip,nama_pl,n_pr', 'tmlelang:id,n_lelang', 'tmpelamar_status:id,n_status'])->where('tmpelamars.tmpelamar_status_id', 3);

        $tmlelang_id = $request->tmlelang_id;

        // dd($tmlelang_id);

        $tmpelamar = Tmpelamar::pemenang($tmlelang_id);

        // $tmpelamar2 = Tmpelamar::all();

        // dd($tmpelamar);

        // if ($request->tmlelang_id != 99) {
        //     $tmpelamar->where('tmlelang_id', $request->tmlelang_id);
        // }
        return Datatables::of($tmpelamar)
            ->addColumn('action', function ($p) {
                $pemenang = '';
                if ($p->c_pemenang == 1 && $p->c_pemenang != '') {
                    return "
                            <a href='" . route('arsipSetuju.edit', $p->id) . "' title='Tampilan Berkas Lamaran'><i class='icon-file-text-o mr-1'></i></a>
                            <a href='#' onclick='cek(" . $p->id . ")' title='pemenang terpilih'><i class='icon icon-check green-text'></i></a>";
                } else {
                    $r = '';
                    if ($p->status == 0) {
                        $r = "<a href='" . route('arsipSetuju.edit', $p->id) . "' title='Tampilan Berkas Lamaran'><i class='icon-file-text-o mr-1'></i></a>
                              <a href='#' onclick='cekPemenang(" . $p->id . ")' title='pilih pemenang'><i class='icon icon-check red-text'></i></>";
                    } else {
                        $r = "<a href='" . route('arsipSetuju.edit', $p->id) . "' title='Tampilan Berkas Lamaran'><i class='icon-file-text-o mr-1'></i></a>
                              <a title='Pemenang Terpilih'><i class='icon icon-check black-text'></i></a>";
                    }
                    return $r;
                }
            })
            ->editColumn('penawaran', function ($p) {
                return number_format($p->penawaran, 2, ',', '.');
            })
            ->editColumn('c_pemenang', function ($p) {
                if ($p->c_pemenang == 1 && $p->c_pemenang != 0) {
                    return $p->c_pemenang = 'Di Terima <i class="icon icon-check green-text"></i>';
                } else {
                    return $p->c_pemenang = 'Di Tolak';
                }
            })

            ->rawColumns(['tmpelamar_status.n_status', 'action'])
            ->toJson();
    }

    public function edit($id)
    {
        $tmpelamar = Tmpelamar::whereid($id)->with(['tmregistrasi', 'tmlelang:id,n_lelang', 'tmpelamar_status:id,n_status'])->first();
        if (!$tmpelamar || $tmpelamar->tmpelamar_status_id != 3) {
            return abort(404);
        } else {
            $trpelamar_syarats = Trpelamar_syarat::select('id', 'tmsyarat_id', 'file')->where('tmpelamar_id', $id)->with('tmsyarat:id,n_syarat')->get();
            // $n_golongan = Golongan::whereid($tmpelamar->tmregistrasi->golongan_id)->first()->n_golongan;
            // $n_eselon = Eselon::whereid($tmpelamar->tmregistrasi->eselon_id)->first()->n_eselon;
            return view('seleksi.arsipSetuju.edit', compact('tmpelamar', 'trpelamar_syarats'));
        }
    }

    public function pemenang($id)
    {

        $tmpelamar = Tmpelamar::findOrFail($id);

        if ($tmpelamar->tmpelamar_status_id != 3) {

            //data bukan pada lokasinya
            return response()->json([
                'message' => "Data Not Valid."
            ], 422);
        } else {
            $tmpelamar->c_pemenang = 1;
            $tmpelamar->save();

            return response()->json([
                'nomor' => $tmpelamar->no_pendaftaran,
                'message' => "Pemenang Berhasil Terpilih"
            ]);
        }
    }

    public function cekPemenang($id)
    {
        $find = Tmpelamar::whereid($id)->with(['tmregistrasi', 'tmlelang'])->first();

        return response()->json([
            //tmpelamar
            'no_pendaftaran' => $find->no_pendaftaran,
            'penawaran' => $find->penawaran,
            'id' => $find->id,

            //tmregistrasi pemilik perusahaan
            'nik_pl' => $find->tmregistrasi->nik_pl,
            'kk_pl' => $find->tmregistrasi->kk_pl,
            'nama_pl' => $find->tmregistrasi->nama_pl,
            't_lahir_pl' => $find->tmregistrasi->t_lahir_pl,
            'd_lahir_pl' => $find->tmregistrasi->d_lahir_pl,
            'jk_pl' => $find->tmregistrasi->jk_pl,
            'pekerjaan_pl' => $find->tmregistrasi->pekerjaan_pl,
            'alamat_pl' => $find->tmregistrasi->alamat_pl,
            'no_tlp_pl' => $find->tmregistrasi->no_tlp_pl,
            'foto_pl' => $find->tmregistrasi->foto_pl,

            //env url
            'env' => env('SFTP_SRC') . 'register/',
            'env2' => env('SFTP_SRC') . 'parkir/',

            //tmregistrasi perusahaan
            'n_pr' => $find->tmregistrasi->n_pr,
            'siup_pr' => $find->tmregistrasi->siup_pr,
            'jw_pr' => $find->tmregistrasi->jw_pr,
            'alamat_pr' => $find->tmregistrasi->alamat_pr,
            'email_pr' => $find->tmregistrasi->email_pr,
            'npwp_pr' => $find->tmregistrasi->npwp_pr,

            //tmlelang
            'n_lelang' => $find->tmlelang->n_lelang,
            'foto' => $find->tmlelang->foto
        ]);
        return $find;
    }
}
