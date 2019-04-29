<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Rumpun;

class RumpunController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.rumpun');
    }

    public function store(Request $request)
    {
        $request->validate([
            'n_rumpun' => 'required|unique:rumpuns,n_rumpun',
            'ket' => 'required'
        ]);

        $input = $request->all();
        Rumpun::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data rumpun berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        return Rumpun::find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'n_rumpun' => 'required|unique:rumpuns,n_rumpun,'.$id,
            'ket' => 'required'
        ]);

        $input = $request->all();
        $rumpun = Rumpun::findOrFail($id);
        $rumpun->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data rumpun berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        Rumpun::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data rumpun berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $rumpun = Rumpun::all();
        return Datatables::of($rumpun)
            ->addColumn('action', function($p){
                return "
                    <a href='#' onclick='edit(".$p->id.")' title='Edit Rumpun'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Rumpun'><i class='icon-remove'></i></a>";
            })->rawColumns(['action'])
            ->toJson();
    }
}
