<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\Controller;
use App\Models\Tm_penghasilan_aset;
use App\Models\Tm_penghasilan_rincian_aset;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PendapatanRincianAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = 0;
        $tm_penghasilan_asets = Tm_penghasilan_aset::all();

        return view('income.rincianAset.index', compact('id', 'tm_penghasilan_asets'));
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
            'tm_penghasillan_aset_id' => 'required',
            'no_index'                => 'required'
        ]);

        Tm_penghasilan_rincian_aset::create([
            'tm_penghasillan_aset_id' => $request->tm_penghasilan_aset_id,
            'no_index'                => $request->no_index
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil disimpan.'
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
        return Tm_penghasilan_rincian_aset::whereid($id)->with('tmPenghasilanAset')->first();
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
            'tm_penghasillan_aset_id' => 'required',
            'no_index'                => 'required'
        ]);

        $tm_penghasilan_rincian_aset = Tm_penghasilan_rincian_aset::find($id);

        $tm_penghasilan_rincian_aset->update([
            'tm_penghasillan_aset_id' => $request->tm_penghasilan_aset_id,
            'no_index'                => $request->no_index
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil diperbaharui.'
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
        Tm_penghasilan_rincian_aset::destroy($id);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    /**
     * Display data from datatables
     *
     * @return JSON
     */
    public function api()
    {
        $tmPenghasilanRincianAset = Tm_penghasilan_rincian_aset::with('tmPenghasilanAset')->get();

        // dd($tmPenghasilanRincianAset);

        return DataTables::of($tmPenghasilanRincianAset)
            ->addColumn('action', function ($p) {
                $btnEdit = "<a href='#' onclick='edit(" . $p->id . ")' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
