<?php

namespace App\Http\Controllers\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Tmsyarat;

class SyaratController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lelang.syarat');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'n_syarat' => 'required|unique:tmsyarats,n_syarat',
            'ket' => 'required'
        ]);

        $input = $request->all();
        Tmsyarat::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data syarat berhasil tersimpan.'
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Tmsyarat::find($id);
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
            'n_syarat' => 'required|unique:tmsyarats,n_syarat,'.$id,
            'ket' => 'required'
        ]);

        $input = $request->all();
        $tmsyarat = Tmsyarat::findOrFail($id);
        $tmsyarat->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data syarat berhasil diperbaharui.'
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
        Tmsyarat::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data syarat berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmsyarat = Tmsyarat::all();
        return Datatables::of($tmsyarat)
            ->addColumn('action', function($p){
                return "
                    <a onclick='edit(".$p->id.")' data-fancybox data-src='#formAdd' data-modal='true' href='javascript:;' title='Edit Syarat'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Syarat'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
