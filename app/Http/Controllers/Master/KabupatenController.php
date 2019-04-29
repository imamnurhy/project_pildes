<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Provinsi;
use App\Models\Kabupaten;

class KabupatenController extends Controller
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
    public function index($provinsi_id)
    {
        $provinsi = Provinsi::findOrFail($provinsi_id);
        return view('master.kabupaten', compact('provinsi', 'provinsi_id'));
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
            'provinsi_id' => 'required',
            'kode' => 'required|max:5|unique:kabupatens,kode',
            'n_kabupaten' => 'required'
        ]);

        $input = $request->all();
        Kabupaten::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data kabupaten berhasil tersimpan.'
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
        return Kabupaten::find($id);
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
            'provinsi_id' => 'required',
            'kode' => 'required|max:5|unique:kabupatens,kode,'.$id,
            'n_kabupaten' => 'required'
        ]);

        $input = $request->all();
        $kabupaten = Kabupaten::findOrFail($id);
        $kabupaten->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data kabupaten berhasil diperbaharui.'
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
        Kabupaten::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data kabupaten berhasil dihapus.'
        ]);
    }

    public function api($provinsi_id)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $provinsi_id);
        return Datatables::of($kabupaten)
            ->addColumn('kecamatan', function($p){
                return $p->kecamatans()->count()." <a href='".route('kecamatan.index', $p->id)."' class='text-success pull-right' title='List Kecamatan'><i class='icon-arrow-right mr-1'></i></a>";
            })
            ->addColumn('action', function($p){
                return "
                    <a onclick='edit(".$p->id.")' data-fancybox data-src='#formAdd' data-modal='true' href='javascript:;' title='Edit Kabupaten'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Kabupaten'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['kecamatan', 'action'])
            ->toJson();
    }
}