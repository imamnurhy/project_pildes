<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Rumpun;
use App\Models\Opd;
use App\Models\Tmkategori;
use App\Models\Tmopd;

class OpdController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tmkategoris = Tmkategori::all();
        return view('master.opd', compact('tmkategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tmkategori_id' => 'required',
            'n_lokasi'      => 'required'
        ]);

        $input = $request->all();
        Tmopd::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data opd berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        $tmopd = Tmopd::find($id);

        return $tmopd;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tmkategori_id' => 'required',
            'n_lokasi'      => 'required'
        ]);

        $input = $request->all();
        $tmopd = Tmopd::findOrFail($id);
        $tmopd->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data opd berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        Tmopd::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data opd berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmopd = Tmopd::with('tmkategoris')->get();
        return Datatables::of($tmopd)
            ->editColumn('n_kategori', function ($p) {
                return $p->tmkategoris->n_kategori;
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' onclick='edit(" . $p->id . ")' title='Edit Opd'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Opd'><i class='icon-remove'></i></a>";
            })->rawColumns(['action'])
            ->toJson();
    }
}
