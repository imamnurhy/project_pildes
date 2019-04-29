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

class AdminController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $tmlelangs = Tmlelang::select('id', 'n_lelang')->where('c_status', 1)->get();
        return view('seleksi.admin.table', compact('tmlelangs'));
    }

    public function api(Request $request)
    {
        $tmpelamar = Tmpelamar::select('tmpelamars.id', 'tmpelamars.tmregistrasi_id', 'tmpelamars.tmpelamar_status_id', 'tmpelamars.tmlelang_id', 'tmpelamars.no_pendaftaran', 'tmpelamars.c_admin', 'tmpelamars.c_tolak')->with(['tmregistrasi:id,nip,n_pegawai', 'tmlelang:id,n_lelang', 'tmpelamar_status:id,n_status'])->where('tmpelamars.tmpelamar_status_id', 2);
        if($request->tmlelang_id != 99){
            $tmpelamar->where('tmlelang_id', $request->tmlelang_id);
        }
        if($request->c_tolak != 99){
            $tmpelamar->where('c_tolak', $request->c_tolak);
        }
        return Datatables::of($tmpelamar)
            ->editColumn('tmpelamar_status.n_status', function($p){
                $txtStatus = '';
                if($p->c_tolak == 0){
                    $txtStatus .= "<br/><strong class='text-success'>Di Setujui</strong>";
                }else{
                    $txtStatus .= "<br/><strong class='text-danger'>Di Tolak</strong>";
                }
                if($p->c_admin == 0){
                    $txtStatus .= "<br/>Belum diputuskan.";
                }else{
                    $txtStatus .= "<br/><span class='text-info'>Sudah diputuskan.</span>";
                }
                return '<span class="badge badge-primary r-5">'.$p->tmpelamar_status->n_status.'</span><small>'.$txtStatus.'</small>';
            })
            ->addColumn('action', function($p){
                $btnMutasi = '';
                if($p->c_admin == 1){
                    $btnMutasi .= "<a href='#' onclick='mutasi(".$p->id.")' class='text-success' title='Kirim Berkas'><i class='icon-send'></i></a>";
                }else{
                    $btnMutasi .= "<a class='text-default' title='Kirim Berkas'><i class='icon-send'></i></a>";
                }
                $btnEdit ='';
                if($p->tmpelamar_status_id == 2){
                    $btnEdit .= "<a href='".route('admin.panselnas.edit', $p->id)."' title='Tampilan Berkas Lamaran'><i class='icon-file-text-o mr-2'></i></a>";
                }else{
                    $btnEdit .= "<a class='text-default' title='Tampilan Berkas Lamaran'><i class='icon-file-text-o mr-2'></i></a>";
                }

                return $btnEdit.$btnMutasi;
            })
            ->rawColumns(['tmpelamar_status.n_status', 'action'])
            ->toJson();
    }

    public function edit($id)
    {
        $tmpelamar = Tmpelamar::whereid($id)->with(['tmregistrasi', 'tmlelang:id,n_lelang', 'tmpelamar_status:id,n_status'])->first();
        if(!$tmpelamar || $tmpelamar->tmpelamar_status_id != 2){
            return abort(404);
        }else{
            $trpelamar_syarats = Trpelamar_syarat::select('id', 'tmsyarat_id', 'file')->where('tmpelamar_id', $id)->with('tmsyarat:id,n_syarat')->get();
            $n_golongan = Golongan::whereid($tmpelamar->tmregistrasi->golongan_id)->first()->n_golongan;
            $n_eselon = Eselon::whereid($tmpelamar->tmregistrasi->eselon_id)->first()->n_eselon;
            return view('seleksi.admin.edit', compact('tmpelamar', 'trpelamar_syarats', 'n_golongan', 'n_eselon'));
        }
    }

    public function update(Request $request, $id)
    {
        $tmpelamar = Tmpelamar::findOrFail($id);
        if($tmpelamar->c_tolak == 0){
            $request->validate([
                'd_kesehatan_dari' => 'required|date_format:Y-m-d H:i',
                'd_kesehatan_sampai' => 'required|date_format:Y-m-d H:i',
                'd_assesment_dari' => 'required|date_format:Y-m-d H:i',
                'd_assesment_sampai' => 'required|date_format:Y-m-d H:i',
                'd_wawancara_dari' => 'required|date_format:Y-m-d H:i',
                'd_wawancara_sampai' => 'required|date_format:Y-m-d H:i'
            ]);
            $tmpelamar->d_kesehatan_dari = $request->d_kesehatan_dari.':00';
            $tmpelamar->d_kesehatan_sampai = $request->d_kesehatan_sampai.':00';
            $tmpelamar->d_assesment_dari = $request->d_assesment_dari.':00';
            $tmpelamar->d_assesment_sampai = $request->d_assesment_sampai.':00';
            $tmpelamar->d_wawancara_dari = $request->d_wawancara_dari.':00';
            $tmpelamar->d_wawancara_sampai = $request->d_wawancara_sampai.':00';
        }

        $tmpelamar->c_admin = 1;
        $tmpelamar->d_admin = date('Y-m-d');
        $tmpelamar->save();
    }

    public function mutasi($id)
    {
        //
    }

    public function updateMutasi(Request $request, $id)
    {
        $tmpelamar = Tmpelamar::findOrFail($id);
        if($tmpelamar->tmpelamar_status_id != 2)
        {

            //data bukan pada lokasinya
            return response()->json([
                'message' => "Data Not Valid."
            ], 422);
        }
        else
        {

                //forward => Dikembalikan ke tahap sebelumnya
            if($request->forward == 1)
            {
                $tmpelamar->tmpelamar_status_id = 1;
                $tmpelamar->c_panselnas = 0;
                $tmpelamar->c_admin = 0;
                $tmpelamar->save();

                return response()->json([
                    'message' => "Data berhasil terkirim."
                ]);
            }
            else
            { 
                if($tmpelamar->c_tolak == 0){
                    $tmpelamar->tmpelamar_status_id = 3;
                }else{
                    $tmpelamar->tmpelamar_status_id = 406;
                }
                $tmpelamar->save();

                return response()->json([
                    'message' => "Data berhasil terkirim."
                ]);
            }
        }
    }
}
