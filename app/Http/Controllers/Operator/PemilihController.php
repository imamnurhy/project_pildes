<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Pemilih;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use PDF;


class PemilihController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinsis = Provinsi::select('id', 'kode', 'n_provinsi')->get();
        $pegawai = Pegawai::find(Auth::user()->id);
        return view('operator.pemilih.index', compact('provinsis'));
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
            'nik'          => 'required|min:16|max:16|unique:pemilihs,nik',
            'n_pemilih'    => 'required',
            'telp'         => 'required|string|min:10|max:14|unique:pemilihs,telp',
            't_lahir'      => 'required',
            'd_lahir'      => 'required',
            'jk'           => 'required',
            'alamat'       => 'required',
        ]);

        $input = $request->all();
        Pemilih::create($input);

        return response()->json(['message' => 'Data pemilih berhasil tersimpan.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Pemilih::find($id);
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
            'nik'          => 'required|min:16|max:16',
            'n_pemilih'    => 'required',
            'telp'         => 'required|string|min:10|max:14',
            't_lahir'      => 'required',
            'd_lahir'      => 'required',
            'jk'           => 'required',
            'alamat'       => 'required',
        ]);

        $input = $request->all();
        $pemilih = Pemilih::find($id);
        $pemilih->update($input);

        return response()->json(['message' => 'Data pemilih berhasil diperbaharui.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pemilih::destroy($id);
        return response()->json(['message' => 'Data pemilih berhasil diperbaharui.']);
    }

    public function api()
    {
        $pemilih = Pemilih::all();
        return DataTables::of($pemilih)
            ->editColumn('rt_rw', function ($p) {
                return $p->rt . ' / ' . $p->rw;
            })
            ->addColumn('action', function ($p) {
                $btnEdit = "<a  href='#' onclick='edit(" . $p->id . ")' title='Edit Pemlih'><i class='icon-pencil mr-1'></i></a>";
                $btnDelete = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Pemilih'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnDelete;
            })
            ->rawColumns(['rt_rw', 'action'])
            ->toJson();
    }

    public function cetakUndangan(Request $request)
    {
        $pemilihs = Pemilih::all();
        $pdf = PDF::loadview('operator.pemilih.pdf', compact('pemilihs'));
        return $pdf->stream();
    }
}
