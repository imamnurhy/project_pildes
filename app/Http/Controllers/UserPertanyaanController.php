<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserPertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user_pertanyaan.index');
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function api()
    {
        $tmpertanyaan = DB::table('truser_pertanyaans')
            ->select(
                'truser_pertanyaans.id',
                'pegawais.n_pegawai',
                'tmopds.n_lokasi',
                'tmpertanyaans.n_pertanyaan',
                'tmjenis_asets.n_jenis_aset'
            )
            ->join('pegawais', 'truser_pertanyaans.user_id', 'pegawais.user_id')
            ->join('tmopds', 'pegawais.tmopd_id', 'tmopds.id')
            ->join('tmjenis_aset_tmpertanyaan', 'truser_pertanyaans.tmpertanyaan_id', 'tmjenis_aset_tmpertanyaan.id')
            ->join('tmjenis_asets', 'tmjenis_aset_tmpertanyaan.tmjenis_aset_id', 'tmjenis_asets.id')
            ->join('tmpertanyaans', 'tmjenis_aset_tmpertanyaan.tmpertanyaan_id', 'tmpertanyaans.id')
            ->get();
        // dd($tmpertanyaan);
        return DataTables::of($tmpertanyaan)
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' onclick='edit(" . $p->id . ")' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
