<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Opd;
use App\Models\Unitkerja;

class UnitkerjaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $opds = Opd::all();
        return view('master.unitkerja', compact('opds'));
    }

    public function store(Request $request)
    {
        $opd_id = $request->input('opd_id');
        $n_unitkerja = $request->input('n_unitkerja');

        $cek = Unitkerja::where('opd_id', $opd_id)->where('n_unitkerja', $n_unitkerja)->count();
        if($cek == 1)
        {
            $err = [
                'n_unitkerja' => ["The unitkerja has already been taken."]
            ];
            return response()->json([
                'message' => "The given data was invalid.",
                'errors'  => $err
            ], 422);
        }
        else
        {
            $request->validate([
                'n_unitkerja' => 'required',
                'initial' => 'required',
                'opd_id' => 'required'
            ]);

            $input = $request->all();
            Unitkerja::create($input);

            return response()->json([
                'success' => true,
                'message' => 'Data unit kerja berhasil tersimpan.'
            ]);
        }
    }

    public function edit($id)
    {
        $unitkerja = unitkerja::find($id);
        return $unitkerja;
    }
    
    public function update(Request $request, $id)
    {
        $opd_id = $request->input('opd_id');
        $n_unitkerja = $request->input('n_unitkerja');

        $cek = Unitkerja::where('opd_id', $opd_id)->where('n_unitkerja', $n_unitkerja)->count();
        if($cek > 1)
        {
            $err = [
                'n_unitkerja' => ["The unitkerja has already been taken."]
            ];
            return response()->json([
                'message' => "The given data was invalid.",
                'errors'  => $err
            ], 422);
        }
        else
        {
            $request->validate([
                'n_unitkerja' => 'required',
                'initial' => 'required',
                'opd_id' => 'required'
            ]);

            $input = $request->all();
            $unitkerja = unitkerja::findOrFail($id);
            $unitkerja->update($input);

            return response()->json([
                'success' => true,
                'message' => 'Data unitkerja berhasil diperbaharui.'
            ]);
        }
    }

    public function destroy($id)
    {
        unitkerja::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data unit kerja berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $unitkerja = unitkerja::all();
        return Datatables::of($unitkerja)
            ->editColumn('opd_id', function($p){
                return $p->opd()->first()->initial;
            })
            ->addColumn('action', function($p){
                return "
                    <a href='#' onclick='edit(".$p->id.")' title='Edit Unit Kerja'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Unit Kerja'><i class='icon-remove'></i></a>";
            })->rawColumns(['action'])
            ->toJson();
    }
}