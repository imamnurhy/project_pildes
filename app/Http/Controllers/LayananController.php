<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layanan.index');
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
            'n_layanan' => 'required',
            'bandwidth' => 'required',
            'harga'     => 'required'
        ]);

        Layanan::create($request->all());

        return response()->json([
            'message' => 'Layanan berhasi tersimpan.'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Layanan::find($id);
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
            'n_layanan' => 'required',
            'bandwidth' => 'required',
            'harga'     => 'required'
        ]);

        $layanan = Layanan::find($id);

        $layanan->update($request->all());

        return response()->json([
            'message' => 'Layanan berhasi diperbaharui.'
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
        Layanan::destroy($id);

        return response()->json([
            'message' => 'Layanan berhasil dihapus.'
        ]);
    }


    public function api()
    {
        $layanan = Layanan::all();

        return DataTables::of($layanan)
            ->addColumn('action', function ($p) {
                $btnEdit = "<a onclick='edit(" . $p->id . ")' class='text-blue' title='Edit Layanan'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus layanan'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
