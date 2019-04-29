<?php

namespace App\Http\Controllers\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Tmpengumuman;

class PengumumanController extends Controller
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
        return view('lelang.pengumuman');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = 0;
        return view('lelang._pengumuman.form', compact('id'));
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
            'n_pengumuman' => 'required|unique:tmpengumumans,n_pengumuman',
            'ket' => 'required',
            'c_status' => 'required',
            'tgl' => 'required|date'
        ]);

        $input = $request->all();
        Tmpengumuman::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data pengumuman berhasil tersimpan.'
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
        return view('lelang._pengumuman.form', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Tmpengumuman::findOrFail($id);
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
            'n_pengumuman' => 'required|unique:tmpengumumans,n_pengumuman,'.$id,
            'ket' => 'required',
            'c_status' => 'required',
            'tgl' => 'required|date'
        ]);

        $input = $request->all();
        $tmpengumuman = Tmpengumuman::findOrFail($id);
        $tmpengumuman->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data pengumuman berhasil diperbaharui.'
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
        Tmpengumuman::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data pengumuman berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmpengumuman = Tmpengumuman::all();
        return Datatables::of($tmpengumuman)
            ->editColumn('tgl', function($p){
                return \Carbon\Carbon::parse($p->tgl)->format('d F Y');
            })
            ->editColumn('c_status', function($p){
                if($p->c_status == 1){
                    $txt = "<span class='badge r-3 badge-primary'>Tampil</span>";
                }else{
                    $txt = "<span class='badge r-3'>Tidak Tampil</span>";
                }
                return $txt;
            })
            ->addColumn('action', function($p){
                return "
                    <a href='". route('pengumuman.show', $p->id) ."' title='Edit Pengumuman'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Pengumuman'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['c_status', 'action'])
            ->toJson();
    }
}
