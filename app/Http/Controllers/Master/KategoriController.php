<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Tmkategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.kategori');
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
            'n_kategori' => 'required'
        ]);

        Tmkategori::create([
            'n_kategori' => $request->n_kategori,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data kategori berhasil tersimpan.'
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
        return Tmkategori::find($id);
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
            'n_kategori' => 'required'
        ]);

        $tmkategori = Tmkategori::find($id);
        $tmkategori->update([
            'n_kategori' => $request->n_kategori
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data kategori berhasil diperbaharui.'
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
        Tmkategori::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data kategori berhasil dihapus.'
        ]);
    }


    /**
     * Get data kategori
     *
     * @return json
     */
    public function api()
    {
        $tmkategori = Tmkategori::all();
        return DataTables::of($tmkategori)
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' onclick='edit(" . $p->id . ")' title='Edit Opd'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Opd'><i class='icon-remove'></i></a>";
            })->rawColumns(['action'])
            ->toJson();
    }
}
