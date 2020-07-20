<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Models\Tmjenis_aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class JenisAsetController extends Controller
{
    public function index()
    {
        return view('brand.jenis_asset.index');
    }

    public function create()
    {
        $id = 0;
        return view('brand.jenis_asset.form', compact(['id']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'n_jenis_aset' => 'required',
        ]);

        Tmjenis_aset::create([
            'n_jenis_aset' => $request->n_jenis_aset
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function show($id)
    {
        return view('brand.jenis_asset.form', compact(['id']));
    }

    public function edit($id)
    {
        $tmmerek = Tmjenis_aset::find($id);

        return response()->json(
            [
                'id'            => $tmmerek->id,
                'n_jenis_aset' => $tmmerek->n_jenis_aset,
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'n_jenis_aset' => 'required',
        ]);

        $tmjenis_aset = Tmjenis_aset::find($id);

        $tmjenis_aset->update([
            'n_jenis_aset' => $request->n_jenis_aset
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        Tmjenis_aset::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmjenis_asets = Tmjenis_aset::all();
        $tmaset = DB::table('tmasets')
            ->pluck('jenis_aset_id')
            ->toArray();
        return DataTables::of($tmjenis_asets)
            ->addColumn('action', function ($p) use ($tmaset) {
                $buttonAction = '';
                if (in_array($p->id, $tmaset)) {
                    $buttonAction = "
                    <a title='Edit Jenis'><i class='icon-pencil mr-1'></i></a>
                    <a title='Hapus Jenis'><i class='icon-remove'></i></a>
                    ";
                } else {
                    $buttonAction = "
                   <a  href='" . route('brand.show', $p->id) . "' title='Edit Jenis'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus jenis'><i class='icon-remove'></i></a>";
                }

                return $buttonAction;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
