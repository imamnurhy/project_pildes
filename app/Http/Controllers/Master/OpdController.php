<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Rumpun;
use App\Models\Opd;

class OpdController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $rumpuns = Rumpun::all();
        return view('master.opd', compact('rumpuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:opds,kode',
            'n_opd' => 'required',
            'initial' => 'required',
            'rumpun_id' => 'required'
        ]);

        $input = $request->all();
        Opd::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data opd berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        $opd = Opd::find($id);
        return $opd;
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|unique:opds,kode,'.$id,
            'n_opd' => 'required',
            'initial' => 'required',
            'rumpun_id' => 'required'
        ]);

        $input = $request->all();
        $opd = Opd::findOrFail($id);
        $opd->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data opd berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        Opd::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data opd berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $opd = Opd::all();
        return Datatables::of($opd)
            ->editColumn('rumpun_id', function($p){
                $rumpun = $p->rumpun()->first();
                if($rumpun){
                    return $rumpun->n_rumpun;
                }
                return '-';
            })
            ->addColumn('action', function($p){
                return "
                    <a href='#' onclick='edit(".$p->id.")' title='Edit Opd'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Opd'><i class='icon-remove'></i></a>";
            })->rawColumns(['action'])
            ->toJson();
    }
}
