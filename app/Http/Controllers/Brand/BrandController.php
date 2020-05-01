<?php

namespace App\Http\Controllers\Brand;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tmmerk;
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
        return view('brand.form', compact(['id']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'n_merk' => 'required',
        ]);

        Tmmerk::create([
            'n_merk' => $request->n_merk
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function show($id)
    {
        return view('brand.form', compact(['id']));
    }

    public function edit($id)
    {
        $tmmerk = Tmmerk::find($id);

        return response()->json(
            [
                'id'      => $tmmerk->id,
                'n_merk' => $tmmerk->n_merk,
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'n_merk' => 'required',
        ]);

        $tmmerk = Tmmerk::find($id);

        $tmmerk->update([
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
        $tmmerk = Tmmerk::all();

        return DataTables::of($tmmerk)
            ->addColumn('action', function ($p) {
                return "
                   <a href='" . route('brand.show', $p->id) . "' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
