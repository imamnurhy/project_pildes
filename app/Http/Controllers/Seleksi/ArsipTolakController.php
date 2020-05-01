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

class ArsipTolakController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tmlelangs = Tmlelang::select('id', 'n_lelang')->where('c_status', 1)->get();
        return view('seleksi.arsipTolak.table', compact('tmlelangs'));
    }

    public function api(Request $request)
    {
        $tmpelamar = Tmpelamar::select('tmpelamars.id', 'tmpelamars.tmregistrasi_id', 'tmpelamars.tmpelamar_status_id', 'tmpelamars.tmlelang_id', 'tmpelamars.no_pendaftaran', 'tmpelamars.c_admin', 'tmpelamars.c_tolak', 'tmpelamars.penawaran')->with(['tmregistrasi:id,nip,nama_pl,n_pr', 'tmlelang:id,n_lelang', 'tmpelamar_status:id,n_status'])->where('tmpelamars.tmpelamar_status_id', 406);
        if ($request->tmlelang_id != 99) {
            $tmpelamar->where('tmlelang_id', $request->tmlelang_id);
        }
        return Datatables::of($tmpelamar)
            ->addColumn('action', function ($p) {
                return "<a href='" . route('arsipTolak.edit', $p->id) . "' title='Tampilan Berkas Lamaran'><i class='icon-file-text-o mr-2'></i></a>";
            })
        
            ->editColumn('penawaran', function($p){
                return number_format($p->penawaran,2,',','.');
            })

            ->rawColumns(['tmpelamar_status.n_status', 'action'])
            ->toJson();
    }

    public function edit($id)
    {
        $tmpelamar = Tmpelamar::whereid($id)->with(['tmregistrasi', 'tmlelang:id,n_lelang', 'tmpelamar_status:id,n_status'])->first();
        if (!$tmpelamar || $tmpelamar->tmpelamar_status_id != 406) {
            return abort(404);
        } else {
            $trpelamar_syarats = Trpelamar_syarat::select('id', 'tmsyarat_id', 'file')->where('tmpelamar_id', $id)->with('tmsyarat:id,n_syarat')->get();
            // $n_golongan = Golongan::whereid($tmpelamar->tmregistrasi->golongan_id)->first()->n_golongan;
            // $n_eselon = Eselon::whereid($tmpelamar->tmregistrasi->eselon_id)->first()->n_eselon;
            return view('seleksi.arsipTolak.edit', compact('tmpelamar', 'trpelamar_syarats'));
        }
    }
}
