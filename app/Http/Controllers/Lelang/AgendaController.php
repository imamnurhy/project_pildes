<?php

namespace App\Http\Controllers\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Tmagenda;

class AgendaController extends Controller
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
        return view('lelang.agenda');
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
            'n_agenda' => 'required|unique:tmagendas,n_agenda',
            'c_status' => 'required',
            'ket' => 'required',
            'd_dari' => 'required|date',
            'd_sampai' => 'required|date'
        ]);

        $input = $request->all();
        Tmagenda::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data agenda berhasil tersimpan.'
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
        return Tmagenda::findOrFail($id);
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
            'n_agenda' => 'required|unique:tmagendas,n_agenda,'.$id,
            'c_status' => 'required',
            'ket' => 'required',
            'd_dari' => 'required|date',
            'd_sampai' => 'required|date'
        ]);

        $input = $request->all();
        $tmagenda = Tmagenda::findOrFail($id);
        $tmagenda->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data agenda berhasil diperbaharui.'
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
        Tmagenda::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data agenda berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmagenda = Tmagenda::select('id', 'c_status', 'n_agenda', 'd_dari', 'd_sampai');
        return Datatables::of($tmagenda)
            ->editColumn('d_dari', function($p){
                return \Carbon\Carbon::parse($p->d_dari)->format('d F Y');
            })
            ->editColumn('d_sampai', function($p){
                return \Carbon\Carbon::parse($p->d_sampai)->format('d F Y');
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
                    <a href='#' onclick='edit(".$p->id.")' title='Edit Lelang'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Lelang'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['c_status', 'action'])
            ->toJson();
    }
}
