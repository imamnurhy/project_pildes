<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Tmregistrasi;
use App\Models\Tmpelamar;

class SeleksiController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('report.seleksi.filter');
    }

    public function api(Request $request)
    {
        $tmpelamar = Tmpelamar::select('tmpelamars.id', 'tmpelamars.tmregistrasi_id', 'tmpelamars.tmpelamar_status_id', 'tmpelamars.tmlelang_id', 'tmpelamars.no_pendaftaran', 'tmpelamars.n_panselnas', 'tmpelamars.c_tolak')
            ->whereBetween('tmpelamars.created_at', [$request->d_dari.' 00:00:00', $request->d_sampai.' 23:59:59'])
            ->with(['tmregistrasi:id,nip,n_pegawai', 'tmlelang:id,n_lelang', 'tmpelamar_status:id,n_status']);
        return Datatables::of($tmpelamar)
            ->editColumn('tmpelamar_status.n_status', function($p){
                $txtStatus = '';
                if($p->n_panselnas == ''){
                    $txtStatus .= "<br/> Belum diseleksi. ";
                }else{
                    if($p->c_tolak == 0){
                        $txtStatus .= "<br/><strong class='text-success'> Di Setujui </strong>";
                    }else{
                        $txtStatus .= "<br/><strong class='text-danger'> Di Tolak </strong>";
                    }
                    $txtStatus .= "<br/> Oleh : ".$p->n_panselnas;
                }
                return '<span class="badge badge-primary r-5">'.$p->tmpelamar_status->n_status.'</span><small>'.$txtStatus.'</small>';
            })
            ->rawColumns(['tmpelamar_status.n_status'])
            ->toJson();
    }

    public function exportToExcel($d_dari, $d_sampai)
    {
        $tmpelamars = Tmpelamar::whereBetween('tmpelamars.created_at', [$d_dari.' 00:00:00', $d_sampai.' 23:59:59'])
            ->with(['tmregistrasi', 'tmlelang:id,n_lelang', 'tmpelamar_status:id,n_status'])->get();
        return view('report.seleksi.export', compact('tmpelamars', 'd_dari', 'd_sampai'));
    }
}
