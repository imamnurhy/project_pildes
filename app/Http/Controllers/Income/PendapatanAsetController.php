<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\Controller;
use App\Models\Tm_penghasilan_aset;
use App\Models\Tm_asset_kendaraan;
use App\Models\Tmaset_barang;
use App\Models\Tmaset_tanah;
use App\Models\Tm_master_aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PendapatanAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = 0;
        $tmmaster_asets = DB::table('tmmaster_asset')
            ->select(
                'tmmaster_asset.id',
                'tmjenis_asets.n_jenis_aset',
                'tmjenis_aset_rincians.n_rincian'
            )
            ->join('tmjenis_asets', 'tmmaster_asset.id_jenis_asset', 'tmjenis_asets.id')
            ->join('tmjenis_aset_rincians', 'tmmaster_asset.id_rincian_jenis_asset', 'tmjenis_aset_rincians.id')
            ->get();

        return view('income.aset.index', compact('id', 'tmmaster_asets'));
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
            'tmmaster_aset_id' => 'required',
            'n_aset'            => 'required',
            'tahun'             => 'required',
            'tgl_pendapatan'    => 'required',
            'nilai'             => 'required',
        ]);

        foreach ($request->tahun as $key => $value) {
            Tm_penghasilan_aset::create([
                'tmmaster_aset_id' => $request->tmmaster_aset_id,
                'n_aset' => $request->n_aset,
                'tahun' => $request->tahun[$key],
                'tgl_pendapatan' => $request->tgl_pendapatan[$key],
                'nilai' => $request->nilai[$key],
            ]);
        }

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
        return Tm_penghasilan_aset::whereid($id)->with('tmMasterAset')->first();
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
            'tmmaster_aset_id' => 'required',
            'n_aset'           => 'required',
            'tahun_e'          => 'required',
            'tgl_pendapatan_e' => 'required',
            'nilai_e'          => 'required',
        ]);

        $tm_penghasillan_aset = Tm_penghasilan_aset::find($id);

        $tm_penghasillan_aset->update([
            'tmmaster_aset_id' => $request->tmmaster_aset_id,
            'n_aset'           => $request->n_aset,
            'tahun'            => $request->tahun_e,
            'tgl_pendapatan'   => $request->tgl_pendapatan_e,
            'nilai'            => $request->nilai_e,
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
        Tm_penghasilan_aset::destroy($id);

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    /**
     * Display data from datatables
     *
     * @return json
     */
    public function api()
    {
        $tm_penghasillan_aset = Tm_penghasilan_aset::with(['tmMasterAset.tmJenisAset'])->get();

        // dd($tm_penghasillan_aset);

        return DataTables::of($tm_penghasillan_aset)
            ->addColumn('action', function ($p) {
                $btnEdit = "<a href='#' onclick='edit(" . $p->id . ")' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->rawColumns(['action'])
            ->toJson();
    }



    public function getJenisAset($id)
    {
        $tmmaster_aset = Tm_master_aset::with('tmJenisAset')->whereid($id)->first();

        if ($tmmaster_aset->tmJenisAset->kode == 'tanah') {
            return Tmaset_tanah::select('nm_lahan as n_aset')->where('id_master_aset', $tmmaster_aset->id)->get();
        } else if ($tmmaster_aset->tmJenisAset->kode == 'barang') {
            return Tmaset_barang::select('jenis as n_aset')->where('id_master_aset', $tmmaster_aset->id)->get();
        } else if ($tmmaster_aset->tmJenisAset->kode == 'kendaraan') {
            return Tm_asset_kendaraan::select('merek as n_aset')->where('tmmaster_asset_id', $tmmaster_aset->id)->get();
        }
    }
}
