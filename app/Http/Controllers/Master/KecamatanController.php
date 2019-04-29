<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Kabupaten;
use App\Models\Kecamatan;

class KecamatanController extends Controller
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
    public function index($kabupaten_id)
    {
        $kabupaten = Kabupaten::findOrFail($kabupaten_id);
        return view('master.kecamatan', compact('kabupaten', 'kabupaten_id'));
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
            'kabupaten_id' => 'required',
            'kode' => 'required|max:8|unique:kecamatans,kode',
            'n_kecamatan' => 'required'
        ]);

        $input = $request->all();
        Kecamatan::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data kecamatan berhasil tersimpan.'
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
        return Kecamatan::find($id);
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
            'kabupaten_id' => 'required',
            'kode' => 'required|max:8|unique:kecamatans,kode,'.$id,
            'n_kecamatan' => 'required'
        ]);

        $input = $request->all();
        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data kecamatan berhasil diperbaharui.'
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
        Kecamatan::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data kecamatan berhasil dihapus.'
        ]);
    }

    public function api($kabupaten_id)
    {
        $kecamatan = Kecamatan::where('kabupaten_id', $kabupaten_id);
        return Datatables::of($kecamatan)
            ->addColumn('kelurahan', function($p){
                return $p->kelurahans()->count()." <a href='".route('kelurahan.index', $p->id)."' class='text-success pull-right' title='List Kelurahan'><i class='icon-arrow-right mr-1'></i></a>";
            })
            ->addColumn('action', function($p){
                return "
                    <a onclick='edit(".$p->id.")' data-fancybox data-src='#formAdd' data-modal='true' href='javascript:;' title='Edit Kecamatan'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Kecamtan'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['kelurahan', 'action'])
            ->toJson();
    }
}