<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Tm_pendapatan;
use App\Models\Tmjenis_aset;
use App\Models\Tmjenis_aset_rincian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use PDF;


class ReportController extends Controller
{

    public function reportAset()
    {
        $tmJenisAsets = Tmjenis_aset::all();
        return view('report.aset', compact('tmJenisAsets'));
    }

    public function reportAsetApi(Request $request)
    {
        $tm_pendapatan = Tm_pendapatan::select('id', DB::raw('sum(nilai) nilai'), 'tmjenis_aset_id', 'tmjenis_aset_rincian_id', DB::raw('count(*) as total'))->with('tmJenisAset')->groupBy('tmjenis_aset_id');

        if ($request->tmjenis_aset_id != '99') {
            $tm_pendapatan->where('tmjenis_aset_id', $request->tmjenis_aset_id);
        }

        return DataTables::of($tm_pendapatan)
            ->editColumn('jml_aset', function ($p) {
                return $p->total;
            })
            ->editColumn('ttl_pendapatan', function ($p) {
                $ttl_nilai = 0;
                $ttl_nilai += $p->nilai;

                return number_format($ttl_nilai, 2);
            })
            ->editColumn('tm_jenis_aset.n_jenis_aset', function ($p) {
                return "<a href='" . route('report.aset.detail', $p->tmJenisAset->id) . "'>" . $p->tmJenisAset->n_jenis_aset . "</a>";
            })
            ->rawColumns(['tm_jenis_aset.n_jenis_aset'])
            ->toJson();
    }

    public function getAsetRincian($tmjenis_aset_id)
    {
        return Tmjenis_aset_rincian::where('tmjenis_aset_id', $tmjenis_aset_id)->get();
    }

    public function reportAsetDetail($id)
    {
        return view('report.aset_detail', compact('id'));
    }

    public function reportAsetDetailApi($id)
    {
        $tmJenisAsetRincian = Tm_pendapatan::with('tmJenisAsetRincian')->where('tmjenis_aset_id', $id);

        return DataTables::of($tmJenisAsetRincian)
            ->editColumn('nilai', function ($p) {
                return number_format($p->nilai, 2);
            })
            ->toJson();
    }


    public function reportPemilik()
    {
        $pegawai = Pegawai::all();
        return view('report.pemilik', compact('pegawai'));
    }

    public function reportPemilikApi(Request $request)
    {
        $tm_pendapatan = Tm_pendapatan::select('id', 'n_pegawai', 'pegawai_id', DB::raw('sum(nilai) nilai'));

        if ($request->pegawai_id != '99') {
            $tm_pendapatan->where('pegawai_id', $request->pegawai_id);
        }

        return DataTables::of($tm_pendapatan)
            ->editColumn('jml_aset', function ($p) {
                return $p->count();
            })
            ->editColumn('ttl_pendapatan', function ($p) {
                return number_format($p->nilai, 2);
            })
            ->toJson();
    }

    public function reportPemilikExportPdf(Request $request)
    {
        $tm_pendapatan = Tm_pendapatan::select('id', 'n_pegawai', 'pegawai_id', DB::raw('sum(nilai) nilai'));

        if ($request->pegawai_id != '99') {
            $tm_pendapatan->where('pegawai_id', $request->pegawai_id);
        }

        $pdf = PDF::loadview('report._export._pemilik', ['tm_pendapatan' => $tm_pendapatan]);
        $date = Carbon::now();
        $pdf_file = $date . '_report_pemilik.pdf';
        $pdf_path = 'pdf/' . $pdf_file;
        $pdf->save($pdf_path);

        return asset($pdf_path);
    }
}
