<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Tm_pendapatan;
use App\Models\Tmjenis_aset;
use App\Models\Tmjenis_aset_rincian;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{

    public function reportAset()
    {
        $pegawais = Pegawai::all();
        $tmJenisAsets = Tmjenis_aset::all();
        return view('report.reportAset', compact('pegawais', 'tmJenisAsets'));
    }

    public function reportAsetApi(Request $request)
    {
        $tm_pendapatan = Tm_pendapatan::with('tmmasterAset');

        if ($request->pegawai_id != '99') {
            $tm_pendapatan->where('pegawai_id', $request->pegawai_id);
        }

        if ($request->tmjenis_aset_id != '99') {
            $tm_pendapatan->whereHas('tmmasterAset', function ($q) use ($request) {
                return $q->where('id_jenis_asset', '=', $request->tmjenis_aset_id);
            });
        }
        if ($request->tmjenis_aset_rincian_id != '99') {
            $tm_pendapatan->whereHas('tmmasterAset', function ($q) use ($request) {
                return $q->where('id_rincian_jenis_asset', '=', $request->tmjenis_aset_rincian_id);
            });
        }

        if ($request->tgl_pendapatan != '99') {
            $tm_pendapatan->whereYear('tgl_pendapatan', $request->tgl_pendapatan);
        }

        return DataTables::of($tm_pendapatan)
            ->toJson();
    }

    public function getAsetRincian($tmjenis_aset_id)
    {
        return Tmjenis_aset_rincian::where('tmjenis_aset_id', $tmjenis_aset_id)->get();
    }
}
