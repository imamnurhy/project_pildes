<?php

namespace App\Http\Controllers;

use App\Models\Tmjenis_aset;
use App\Models\Tmjenis_aset_tmpertanyaan;
use App\Models\Tmpertanyaan;
use App\Models\Trpertanyaan_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class JenisPertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tmjenis_asets = Tmjenis_aset::all();
        $tmpertanyaans = Tmpertanyaan::all();
        return view('jenis_pertanyaan.index', compact('tmjenis_asets', 'tmpertanyaans'));
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
            'tmjenis_aset_id' => 'required',
            'tmpertanyaan_id'  => 'required',
        ]);

        Tmjenis_aset_tmpertanyaan::create([
            'tmjenis_aset_id' => $request->tmjenis_aset_id,
            'tmpertanyaan_id' => $request->tmpertanyaan_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil tersimpan.'
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Tmjenis_aset_tmpertanyaan::find($id);
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
            'tmjenis_aset_id' => 'required',
            'tmpertanyaan_id' => 'required',
        ]);
        $data = Tmjenis_aset_tmpertanyaan::find($id);
        $data->update([
            'tmjenis_aset_id' => $request->tmjenis_aset_id,
            'tmpertanyaan_id' => $request->tmpertanyaan_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil Diperbaharui.'
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
        Tmjenis_aset_tmpertanyaan::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $data = DB::table('tmjenis_aset_tmpertanyaan')
            ->select('tmjenis_aset_tmpertanyaan.id', 'tmpertanyaans.n_pertanyaan', 'tmjenis_asets.n_jenis_aset')
            ->join('tmpertanyaans', 'tmjenis_aset_tmpertanyaan.tmpertanyaan_id', 'tmpertanyaans.id')
            ->join('tmjenis_asets', 'tmjenis_aset_tmpertanyaan.tmjenis_aset_id', 'tmjenis_asets.id')
            ->get();

        return DataTables::of($data)
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' onclick='edit(" . $p->id . ")' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['n_pertanyaan', 'action'])
            ->toJson();
    }
}
