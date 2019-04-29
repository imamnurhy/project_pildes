<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Provinsi;

class ProvinsiController extends Controller
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
        return view('master.provinsi');
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
            'kode' => 'required|unique:provinsis,kode',
            'n_provinsi' => 'required'
        ]);

        $input = $request->all();
        Provinsi::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data provinsi berhasil tersimpan.'
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
        return Provinsi::find($id);
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
            'kode' => 'required|unique:provinsis,kode,'.$id,
            'n_provinsi' => 'required'
        ]);

        $input = $request->all();
        $provinsi = Provinsi::findOrFail($id);
        $provinsi->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data provinsi berhasil diperbaharui.'
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
        Provinsi::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data provinsi berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $provinsi = Provinsi::all();
        return Datatables::of($provinsi)
            ->addColumn('kabupaten', function($p){
                return $p->kabupatens()->count()." <a href='".route('kabupaten.index', $p->id)."' class='text-success pull-right' title='List Kabupaten'><i class='icon-arrow-right mr-1'></i></a>";
            })
            ->addColumn('action', function($p){
                return "
                    <a onclick='edit(".$p->id.")' data-fancybox data-src='#formAdd' data-modal='true' href='javascript:;' title='Edit Provinsi'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Provinsi'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['kabupaten', 'action'])
            ->toJson();
    }
}