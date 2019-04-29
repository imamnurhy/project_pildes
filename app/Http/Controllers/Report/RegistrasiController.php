<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Tmregistrasi;

class RegistrasiController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('report.registrasi.filter');
    }

    public function api(Request $request)
    {
        $tmregistrasi = Tmregistrasi::whereBetween('created_at', [$request->d_dari.' 00:00:00', $request->d_sampai.' 23:59:59']);
        return Datatables::of($tmregistrasi)
            ->editColumn('created_at', function($tmregistrasi){
                return \Carbon\Carbon::parse($tmregistrasi->created_at)->format('d F Y H:i:s');
            })
            ->toJson();
    }

    public function exportToExcel($d_dari, $d_sampai)
    {
        $tmregistrasis = Tmregistrasi::whereBetween('created_at', [$d_dari.' 00:00:00', $d_sampai.' 23:59:59'])->with(['eselon:id,n_eselon', 'golongan:id,n_golongan'])->get();
        return view('report.registrasi.export', compact('tmregistrasis', 'd_dari', 'd_sampai'));
    }
}
