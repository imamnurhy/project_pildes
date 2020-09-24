<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tm_pendapatan;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{

    public function reportAset()
    {
        return view('report.reportAset');
    }

    public function reportAsetApi(Request $request)
    {
        $tm_pendapatan = Tm_pendapatan::with('tmmasterAset.tmJenisAset')->get();

        return DataTables::of($tm_pendapatan)
            ->toJson();
    }
}
