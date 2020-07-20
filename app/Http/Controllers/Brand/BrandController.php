<?php

namespace App\Http\Controllers\Brand;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tmjenis_aset;
use App\Models\Tmmerk;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    public function index()
    {
        return view('brand.index');
    }

    public function create()
    {
        $id = 0;
        $tmjenis_asets = Tmjenis_aset::all();
        return view('brand.form', compact(['id', 'tmjenis_asets']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'n_merk' => 'required',
            'tmjenis_aset_id' => 'required'
        ]);

        Tmmerk::create([
            'id_nama_aset' => $request->tmjenis_aset_id,
            'n_merk' => $request->n_merk
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function show($id)
    {
        $tmjenis_asets = Tmjenis_aset::all();

        return view('brand.form', compact(['id', 'tmjenis_asets']));
    }

    public function edit($id)
    {
        return  Tmmerk::find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'n_merk' => 'required',
            'tmjenis_aset_id' => 'required'

        ]);

        $tmmerk = Tmmerk::find($id);

        $tmmerk->update([
            'id_nama_aset' => $request->tmjenis_aset_id,
            'n_merk' => $request->n_merk
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        Tmmerk::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmmerk = DB::table('tmmerks')
            ->select('tmmerks.id', 'tmmerks.n_merk', 'tmjenis_asets.n_jenis_aset')
            ->join('tmjenis_asets', 'tmmerks.id_nama_aset', 'tmjenis_asets.id')
            ->get();
        $tmaset = DB::table('tmasets')
            ->pluck('merk_id')
            ->toArray();
        // dd($tmaset);



        return DataTables::of($tmmerk)
            ->addColumn('action', function ($p) use ($tmaset) {

                $buttonAction = '';
                if (in_array($p->id, $tmaset)) {
                    $buttonAction = "
                    <a title='Edit Merek'><i class='icon-pencil mr-1'></i></a>
                    <a title='Hapus Merek'><i class='icon-remove'></i></a>
                    ";
                } else {
                    $buttonAction = "
                   <a  href='" . route('brand.show', $p->id) . "' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
                }

                return $buttonAction;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
