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

class PanselnasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tmlelangs = Tmlelang::select('id', 'n_lelang')->where('c_status', 1)->get();
        $tmpelamar_statuses = Tmpelamar_status::select('id', 'n_status')->get();
        return view('seleksi.panselnas.table', compact('tmlelangs', 'tmpelamar_statuses'));
    }

    public function api(Request $request)
    {
        $tmpelamar = Tmpelamar::select('tmpelamars.id', 'tmpelamars.tmregistrasi_id', 'tmpelamars.tmpelamar_status_id', 'tmpelamars.tmlelang_id', 'tmpelamars.no_pendaftaran', 'tmpelamars.n_panselnas', 'tmpelamars.c_tolak', 'tmpelamars.penawaran')->with(['tmregistrasi:id,nip,nama_pl,n_pr', 'tmlelang:id,n_lelang', 'tmpelamar_status:id,n_status'])->orderBy('tmpelamars.penawaran', 'desc');
        if ($request->tmpelamar_status_id != 99) {
            $tmpelamar->where('tmpelamar_status_id', $request->tmpelamar_status_id);
        }
        if ($request->tmlelang_id != 99) {
            $tmpelamar->where('tmlelang_id', $request->tmlelang_id);
        }
        if ($request->c_tolak != 99) {
            $tmpelamar->where('c_tolak', $request->c_tolak);
        }
        return Datatables::of($tmpelamar)
            ->editColumn('tmpelamar_status.n_status', function ($p) {
                $txtStatus = '';
                if ($p->n_panselnas == '') {
                    $txtStatus .= "<br/> Belum diseleksi. ";
                } else {
                    if ($p->c_tolak == 0) {
                        $txtStatus .= "<br/><strong class='text-success'> Di Setujui </strong>";
                    } else {
                        $txtStatus .= "<br/><strong class='text-danger'> Di Tolak </strong>";
                    }
                    $txtStatus .= "<br/> Oleh : " . $p->n_panselnas;
                }
                return '<span class="badge badge-primary r-5">' . $p->tmpelamar_status->n_status . '</span><small>' . $txtStatus . '</small>';
            })
            ->editColumn('penawaran', function ($p) {
                return number_format($p->penawaran, 2, ',', '.');
            })
            ->addColumn('action', function ($p) {
                $btnMutasi = '';
                if ($p->tmpelamar_status_id == 1 && $p->n_panselnas != '') {
                    $btnMutasi .= "<a href='#' onclick='mutasi(" . $p->id . ")' class='text-success' title='Kirim Berkas'><i class='icon-send'></i></a>";
                } else {
                    $btnMutasi .= "<a class='text-default' title='Kirim Berkas'><i class='icon-send'></i></a>";
                }
                $btnEdit = '';
                if ($p->tmpelamar_status_id == 1) {
                    $btnEdit .= "<a href='" . route('panselnas.edit', $p->id) . "' title='Tampilan Berkas Lamaran'><i class='icon-file-text-o mr-2'></i></a>";
                } else {
                    $btnEdit .= "<a class='text-default' title='Tampilan Berkas Lamaran'><i class='icon-file-text-o mr-2'></i></a>";
                }

                return $btnEdit . $btnMutasi;
            })
            ->rawColumns(['tmpelamar_status.n_status', 'action'])
            ->toJson();
    }

    public function edit($id)
    {
        $tmpelamar = Tmpelamar::whereid($id)->with(['tmregistrasi', 'tmlelang:id,n_lelang', 'tmpelamar_status:id,n_status'])->first();
        if (!$tmpelamar || $tmpelamar->tmpelamar_status_id != 1) {
            return abort(404);
        } else {
            $checkSyarat = 1;
            $trpelamar_syarats = Trpelamar_syarat::select('id', 'tmsyarat_id', 'file')->where('tmpelamar_id', $id)->with('tmsyarat:id,n_syarat')->get();
            return view('seleksi.panselnas.edit', compact('tmpelamar', 'trpelamar_syarats',  'checkSyarat'));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'c_tolak' => 'required'
        ]);
        $c_tolak = 0;
        $alasan_tolak = '';
        if ($request->c_tolak == 1) {
            $request->validate([
                'alasan_tolak' => 'required'
            ]);
            $c_tolak = 1;
            $alasan_tolak = $request->alasan_tolak;
        }

        $tmpelamar = Tmpelamar::findOrFail($id);
        $tmpelamar->panselnas_id = Auth::user()->pegawai->id;
        $tmpelamar->c_panselnas = 1;
        $tmpelamar->d_panselnas = date('Y-m-d');
        $tmpelamar->n_panselnas = Auth::user()->pegawai->n_pegawai;
        $tmpelamar->c_tolak = $c_tolak;
        $tmpelamar->alasan_tolak = $alasan_tolak;
        $tmpelamar->save();
    }

    public function mutasi($id)
    {
        //
    }

    public function updateMutasi($id)
    {
        $tmpelamar = Tmpelamar::findOrFail($id);
        if ($tmpelamar->tmpelamar_status_id != 1) {

            //data bukan pada lokasinya
            return response()->json([
                'message' => "Data Not Valid."
            ], 422);
        } else {
            $tmpelamar->tmpelamar_status_id = 2;
            $tmpelamar->save();

            return response()->json([
                'message' => "Data berhasil terkirim."
            ]);
        }
    }
}
