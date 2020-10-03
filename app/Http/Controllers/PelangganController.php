<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $layanan = Layanan::all();
        return view('pelanggan.index', compact('layanan'));
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
            'n_pelanggan' => 'required',
            'tgl_daftar'  => 'required',
            'layanan_id'  => 'required'
        ]);

        Pelanggan::create($request->all());

        return response()->json(['message' => 'Pelanggan berhasil tersimpan.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Pelanggan::find($id);
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
            'n_pelanggan' => 'required',
            'tgl_daftar'  => 'required',
            'layanan_id'  => 'required'
        ]);

        $pelanggan = Pelanggan::find($id);
        $pelanggan->update($request->all());

        return response()->json(['message' => 'Pelanggan berhasil diperbaharui.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pelanggan::destroy($id);

        return response()->json(['message' => 'Pelanggan berhasil dihapus.']);
    }

    public function api(Request $request)
    {
        $pelanggan = Pelanggan::with('layanan');

        if ($request->tgl_daftar != '') {
            $pelanggan->whereDay('tgl_daftar', Carbon::parse($request->tgl_daftar)->format('d'));
        }

        if ($request->layanan_id != 99) {
            $pelanggan->where('layanan_id', $request->layanan_id);
        }

        return DataTables::of($pelanggan)
            ->editColumn('tgl_daftar', function ($p) {
                return Carbon::parse($p->tgl_daftar)->format('Y-M-d');
            })
            ->addColumn('action', function ($p) {
                $btnEdit = "<a onclick='edit(" . $p->id . ")' class='text-blue' title='Edit Layanan'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus layanan'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->rawColumns(['tgl_daftar', 'action'])
            ->toJson();
    }
}
