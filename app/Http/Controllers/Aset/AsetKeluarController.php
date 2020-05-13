<?php

namespace App\Http\Controllers\Aset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tmopd;
use App\Models\Tmopd_aset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AsetKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('aset.keluar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tmopds = Tmopd::all();
        $tmasets = DB::table('tmasets')
            ->select('tmasets.id', 'tmasets.serial', 'tmasets.tahun', 'tmasets.jumlah', 'tmjenis_asets.n_jenis_aset', 'tmmerks.n_merk')
            ->join('tmjenis_asets', 'tmasets.jenis_aset_id', '=', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmasets.merk_id', '=', 'tmmerks.id')
            ->get();
        return view('aset.keluar.add', compact(['tmopds', 'tmasets']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'opd_id'  => 'required',
            'aset_id.*' => 'required',
            'ket'     => 'required'
        ]);

        foreach ($request->aset_id as $aset_id) {
            Tmopd_aset::create([
                'opd_id'  => $request->opd_id,
                'aset_id' => $aset_id,
                'ket'     => $request->ket,
                'created_by'    => Auth::user()->pegawai->n_pegawai,
                'created_at'    => Carbon::now(),
            ]);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tmopds = Tmopd::all();
        $tmasets = DB::table('tmasets')
            ->select('tmasets.id', 'tmasets.serial', 'tmasets.tahun', 'tmasets.jumlah', 'tmjenis_asets.n_jenis_aset', 'tmmerks.n_merk')
            ->join('tmjenis_asets', 'tmasets.jenis_aset_id', '=', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmasets.merk_id', '=', 'tmmerks.id')
            ->get();
        return view('aset.keluar.edit', compact(['id', 'tmopds', 'tmasets']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tmopd_aset = Tmopd_aset::find($id);

        return response()->json($tmopd_aset);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'opd_id'  => 'required',
            'aset_id' => 'required',
            'ket'     => 'required'
        ]);

        $tmopd_aset = Tmopd_aset::find($id);

        $tmopd_aset->update([
            'opd_id'     => $request->opd_id,
            'aset_id'    => $request->aset_id,
            'ket'        => $request->ket,
            'updated_by' => Auth::user()->pegawai->n_pegawai,
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil diperbaharui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tmopd_aset::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmaset = DB::table('tmopd_asets')
            ->select('tmopd_asets.id', 'tmopds.n_lokasi', 'tmjenis_asets.n_jenis_aset', 'tmasets.serial', 'tmmerks.n_merk', 'tmopd_asets.ket')
            ->join('tmopds', 'tmopd_asets.opd_id', '=', 'tmopds.id')
            ->join('tmasets', 'tmopd_asets.aset_id', '=', 'tmasets.id')
            ->join('tmjenis_asets', 'tmasets.jenis_aset_id', '=', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmasets.merk_id', '=', 'tmmerks.id')
            ->get();

        return DataTables::of($tmaset)
            ->addColumn('action', function ($p) {
                return "<a href='" . route('aset.keluar.show', $p->id) . "' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
