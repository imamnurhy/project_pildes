<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Kecamatan;
use App\Models\Kelurahan;

class KelurahanController extends Controller
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
    public function index($kecamatan_id)
    {
        $kecamatan = Kecamatan::findOrFail($kecamatan_id);
        return view('master.kelurahan', compact('kecamatan', 'kecamatan_id'));
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
            'kecamatan_id' => 'required',
            'kode' => 'required|max:13|unique:kelurahans,kode',
            'n_kelurahan' => 'required'
        ]);

        $input = $request->all();
        Kelurahan::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data kelurahan berhasil tersimpan.'
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
        return Kelurahan::find($id);
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
            'kecamatan_id' => 'required',
            'kode' => 'required|max:13|unique:kelurahans,kode,'.$id,
            'n_kelurahan' => 'required'
        ]);

        $input = $request->all();
        $kelurahan = Kelurahan::findOrFail($id);
        $kelurahan->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data kelurahan berhasil diperbaharui.'
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
        Kelurahan::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data kelurahan berhasil dihapus.'
        ]);
    }

    public function api($kecamatan_id)
    {
        $kelurahan = Kelurahan::where('kecamatan_id', $kecamatan_id);
        return Datatables::of($kelurahan)
            ->addColumn('action', function($p){
                return "
                    <a onclick='edit(".$p->id.")' data-fancybox data-src='#formAdd' data-modal='true' href='javascript:;' title='Edit Kelurahan'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Kecamtan'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
