<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Eselon;

class EselonController extends Controller
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
        return view('master.eselon');
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
            'n_eselon' => 'required|unique:eselons,n_eselon',
            'ket' => 'required'
        ]);

        $input = $request->all();
        Eselon::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data eselon berhasil tersimpan.'
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
        return Eselon::find($id);
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
            'n_eselon' => 'required|unique:eselons,n_eselon,'.$id,
            'ket' => 'required'
        ]);

        $input = $request->all();
        $eselon = Eselon::findOrFail($id);
        $eselon->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data eselon berhasil diperbaharui.'
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
        Eselon::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data eselon berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $eselon = Eselon::all();
        return Datatables::of($eselon)
            ->addColumn('action', function($p){
                return "
                    <a href='#' onclick='edit(".$p->id.")' title='Edit Eselon'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Eselon'><i class='icon-remove'></i></a>";
            })->rawColumns(['action'])
            ->toJson();
    }
}
