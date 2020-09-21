<?php

namespace App\Http\Controllers\JenisAset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tmjenis_aset;
use App\Models\Tmjenis_aset_rincian;
use App\Models\Tmmerk;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RincianJenisAsetController extends Controller
{
    public function index()
    {
        $id = 0;
        $tmjenis_asets = Tmjenis_aset::all();
        return view('jenisAset.indexRincian', compact(['id', 'tmjenis_asets']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'n_rincian' => 'required',
            'tmjenis_aset_id' => 'required'
        ]);

        Tmjenis_aset_rincian::create([
            'tmjenis_aset_id' => $request->tmjenis_aset_id,
            'n_rincian' => $request->n_rincian
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil disimpan.'
        ]);
    }


    public function edit($id)
    {
        return  Tmjenis_aset_rincian::find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'n_rincian' => 'required',
            'tmjenis_aset_id' => 'required'
        ]);

        $rincian = Tmjenis_aset_rincian::find($id);

        $rincian->update([
            'tmjenis_aset_id' => $request->tmjenis_aset_id,
            'n_rincian' => $request->n_rincian
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        Tmjenis_aset_rincian::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function api()
    {

        $rincian = Tmjenis_aset_rincian::with('tmJenisAset')->get();

        return DataTables::of($rincian)
            ->addColumn('action', function ($p) {
                return "<a  href='#' onclick='edit(" . $p->id . ")' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
            })
            ->editColumn('n_jenis_aset', function ($p) {
                return $p->tmJenisAset->n_jenis_aset;
            })
            ->rawColumns(['n_jenis_aset', 'action'])
            ->toJson();
    }
}
