<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Golongan;

class GolonganController extends Controller
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
        return view('master.golongan');
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
            'n_golongan' => 'required|unique:golongans,n_golongan',
            'ket' => 'required'
        ]);

        $input = $request->all();
        Golongan::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data golongan berhasil tersimpan.'
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
        return Golongan::find($id);
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
            'n_golongan' => 'required|unique:golongans,n_golongan,'.$id,
            'ket' => 'required'
        ]);

        $input = $request->all();
        $golongan = Golongan::findOrFail($id);
        $golongan->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data golongan berhasil diperbaharui.'
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
        Golongan::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data golongan berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $golongan = Golongan::all();
        return Datatables::of($golongan)
            ->addColumn('action', function($p){
                return "
                    <a href='#' onclick='edit(".$p->id.")' title='Edit Golongan'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Golongan'><i class='icon-remove'></i></a>";
            })->rawColumns(['action'])
            ->toJson();
    }
}
