<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Tm_pembayaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pembayaran.index', compact('pelanggan'));
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
            'pelanggan_id' => 'required',
            'tgl_bayar'    => 'required',
            'jml_bayar'    => 'required',
            'status'       => 'required'
        ]);

        Tm_pembayaran::create($request->all());

        return response()->json(['message' => 'Pembayaran berhasil tersimpan']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Tm_pembayaran::find($id);
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
            'pelanggan_id' => 'required',
            'tgl_bayar'    => 'required',
            'jml_bayar'    => 'required',
            'status'       => 'required'
        ]);

        $tmPembayaran = Tm_pembayaran::find($id);
        $tmPembayaran->update($request->all());

        return response()->json(['message' => 'Pembayaran berhasil diperbaharui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tm_pembayaran::destroy($id);

        return response()->json(['message' => 'Pembayaran berhasil dihapus']);
    }

    public function api()
    {
        $tm_pembayaran = Tm_pembayaran::with('pelanggan')->get();

        return DataTables::of($tm_pembayaran)
            ->addColumn('action', function ($p) {
                $btnEdit = "<a onclick='edit(" . $p->id . ")' class='text-blue' title='Edit Layanan'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus layanan'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
