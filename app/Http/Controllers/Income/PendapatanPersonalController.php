<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Tm_asset_kendaraan;
use App\Models\Tm_master_aset;
use App\Models\Tm_pendapatan;
use App\Models\Tmaset_barang;
use App\Models\Tmaset_tanah;
use App\Models\Tmjenis_aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PendapatanPersonalController extends Controller
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
            // ->groupBy('tmmaster_asset.id_jenis_asset')
            ->get();


        $tmJenisAsets = Tmjenis_aset::all();

        $pegawais = Pegawai::all();

        return view('income.personal.index', compact(
            'id',
            'tmmaster_asets',
            'pegawais',
            'tmJenisAsets'
        ));
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
            'n_aset'           => 'required',
            'nilai'           => 'required',
        ]);

        $pegawai = Pegawai::find($request->pegawai_id);

        Tm_pendapatan::create([
            'pegawai_id'       => $request->pegawai_id,
            'n_pegawai'        => $pegawai->n_pegawai,
            'tmmaster_aset_id' => $request->tmmaster_aset_id,
            'n_aset'           => $request->n_aset,
            'nilai'            => $request->nilai,
            'tgl_pendapatan'   => $request->tgl_pendapatan
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
        return Tm_pendapatan::find($id);
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
            'nilai'           => 'required',
        ]);

        $tm_pendapatan = Tm_pendapatan::find($id);

        $tm_pendapatan->update([
            'pegawai_id'       => Auth::user()->pegawai->id,
            'n_pegawai'        => Auth::user()->pegawai->n_pegawai,
            'tmmaster_aset_id' => $request->tmmaster_aset_id,
            'n_aset'           => $request->n_aset,
            'nilai'            => $request->nilai,
            'tgl_pendapatan'   => $request->tgl_pendapatan
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
        Tm_pendapatan::destroy($id);

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
        $tm_pendapatan = Tm_pendapatan::with('tmmasterAset.tmJenisAset')->get();

        return DataTables::of($tm_pendapatan)
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
            return Tmaset_tanah::select('nm_lahan as n_aset')
                ->where('id_master_aset', $tmmaster_aset->id)
                ->get();
        } else if ($tmmaster_aset->tmJenisAset->kode == 'barang') {
            return Tmaset_barang::select('jenis as n_aset')
                ->where('id_master_aset', $tmmaster_aset->id)
                ->get();
        } else if ($tmmaster_aset->tmJenisAset->kode == 'kendaraan') {
            return Tm_asset_kendaraan::select('merek as n_aset', 'no_polisi as detail')
                ->where('tmmaster_asset_id', $tmmaster_aset->id)
                ->get();
        } else {
            return response()->json([]);
        }
    }

    public function getMasterAset($id)
    {
        return DB::table('tmmaster_asset')
            ->select(
                'tmmaster_asset.id',
                'tmjenis_aset_rincians.n_rincian'
            )
            ->join('tmjenis_aset_rincians', 'tmmaster_asset.id_rincian_jenis_asset', 'tmjenis_aset_rincians.id')
            ->where('tmmaster_asset.id_jenis_asset', $id)
            ->get();
    }
}
