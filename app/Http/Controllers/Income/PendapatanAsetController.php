<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\Controller;
use App\Models\Tm_penghasilan_aset;
use App\Models\Tm_asset_kendaraan;
use App\Models\Tmaset_barang;
use App\Models\Tmaset_tanah;
use App\Models\Tm_master_aset;
use App\Models\Tm_penghasilan_aset_pt;
use App\Models\Tmjenis_aset;
use App\Models\Tmjenis_aset_rincian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;
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

        $tmJenisAsets = Tmjenis_aset::all();


        return view('income.aset.index', compact('id', 'tmmaster_asets', 'tmJenisAsets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->form_type == 1) {
            $request->validate([
                'tmjenis_aset_id'         => 'required',
                'tmjenis_aset_rincian_id' => 'required',
                'tahun'                   => 'required',
            ]);
            foreach ($request->tahun as $key => $value) {
                Tm_penghasilan_aset::create([
                    'tmjenis_aset_id'        => $request->tmjenis_aset_id,
                    'tmjenis_aset_rincian_id' => $request->tmjenis_aset_rincian_id,
                    'tahun'                   => $request->tahun[$key],
                    'tgl_pendapatan'          => $request->tgl_pendapatan[$key],
                    'nilai'                   => $request->nilai[$key],
                ]);
            }
        } else {
            $request->validate([
                'tmjenis_aset_id'         => 'required',
                'tmjenis_aset_rincian_id' => 'required',
                'no_index'                => 'required',
            ]);

            $tmPenghasilanAset = Tm_penghasilan_aset::create([
                'tmjenis_aset_id'         => $request->tmjenis_aset_id,
                'tmjenis_aset_rincian_id' => $request->tmjenis_aset_rincian_id,
            ]);

            foreach ($request->no_index as $key => $value) {
                $tmPenghasilanAset->tmPenghasilanAsetPt()->create([
                    'tm_penghasilan_aset_id'  => $tmPenghasilanAset->id,
                    'no_index'                => $request->no_index[$key],
                    'jenis_doc'               => $request->jenis_doc[$key],
                    'nm_pekerjaan'            => $request->nm_pekerjaan[$key],
                    'klasifikasi'             => $request->klasifikasi[$key],
                    'dinas'                   => $request->dinas[$key],
                    'nilai_kontrak'           => $request->nilai_kontrak[$key],
                    'ppn'                     => $request->ppn[$key],
                    'nilai_kontrak_exc_ppn'   => $request->nilai_kontrak_exc_ppn[$key],
                    'pph'                     => $request->pph[$key],
                    'nilai_kontrak_bersih'    => $request->nilai_kontrak_bersih[$key],
                    'nm_perusahaan'           => $request->nm_perusahaan[$key],
                    'jml_pendapatan'          => $request->jml_pendapatan[$key]
                ]);
            }
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
        return Tm_penghasilan_aset::whereid($id)->first();
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
            'tmjenis_aset_id'        => 'required',
            'tmjenis_aset_rincian_id' => 'required',
            'tahun_e'                 => 'required',
            'tgl_pendapatan_e'        => 'required',
            'nilai_e'                 => 'required',
        ]);

        $tm_penghasillan_aset = Tm_penghasilan_aset::find($id);

        $tm_penghasillan_aset->update([
            'tmjenis_aset_id'        => $request->tmjenis_aset_id,
            'tmjenis_aset_rincian_id' => $request->tmjenis_aset_rincian_id,
            'tahun'                   => $request->tahun_e,
            'tgl_pendapatan'          => $request->tgl_pendapatan_e,
            'nilai'                   => $request->nilai_e,
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
        $tm_penghasillan_aset = Tm_penghasilan_aset::with('tmJenisAset', 'tmJenisAsetRincian')->get();

        return DataTables::of($tm_penghasillan_aset)
            ->editColumn('tm_jenis_aset.n_jenis_aset', function ($p) {
                if ($p->tmjenis_aset_id == 29) {
                    return "<a href='" . route('pendapatan.aset.showDetailPt', $p->id) . "'>" . $p->tmJenisAset->n_jenis_aset . "</a>";
                } else {
                    return $p->tmJenisAset->n_jenis_aset;
                }
            })
            ->addColumn('action', function ($p) {
                $btnEdit = "<a href='#' onclick='edit(" . $p->id . ")' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "</input><a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->rawColumns(['tm_jenis_aset.n_jenis_aset', 'action'])
            ->toJson();
    }

    public function getRincianAset($id)
    {
        // return DB::table('tmmaster_asset')
        //     ->select(
        //         'tmmaster_asset.id',
        //         'tmjenis_aset_rincians.n_rincian'
        //     )
        //     ->join('tmjenis_aset_rincians', 'tmmaster_asset.id_rincian_jenis_asset', 'tmjenis_aset_rincians.id')
        //     ->where('tmmaster_asset.id_jenis_asset', $id)
        //     ->get();

        return Tmjenis_aset_rincian::where('tmjenis_aset_id', $id)->get();
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


    // Detail pt
    public function showDetailPt($id)
    {
        return view('income.aset._detail_pt', compact('id'));
    }

    public function editDetailPt($id)
    {
        return Tm_penghasilan_aset_pt::find($id);
    }

    public function updateDetailPt(Request $request, $id)
    {
        $request->validate([
            'no_index'                => 'required',
            'jenis_doc'               => 'required',
            'nm_pekerjaan'            => 'required',
            'klasifikasi'             => 'required',
            'dinas'                   => 'required',
            'nilai_kontrak'           => 'required',
            'ppn'                     => 'required',
            'nilai_kontrak_exc_ppn'   => 'required',
            'pph'                     => 'required',
            'nilai_kontrak_bersih'    => 'required',
            'nm_perusahaan'           => 'required',
            'jml_pendapatan'          => 'required',
        ]);

        $tmPenghasilanAsetPt = Tm_penghasilan_aset_pt::find($id);
        $tmPenghasilanAsetPt->update([
            'no_index'                => $request->no_index,
            'jenis_doc'               => $request->jenis_doc,
            'nm_pekerjaan'            => $request->nm_pekerjaan,
            'klasifikasi'             => $request->klasifikasi,
            'dinas'                   => $request->dinas,
            'nilai_kontrak'           => $request->nilai_kontrak,
            'ppn'                     => $request->ppn,
            'nilai_kontrak_exc_ppn'   => $request->nilai_kontrak_exc_ppn,
            'pph'                     => $request->pph,
            'nilai_kontrak_bersih'    => $request->nilai_kontrak_bersih,
            'nm_perusahaan'           => $request->nm_perusahaan,
            'jml_pendapatan'          => $request->jml_pendapatan
        ]);

        return response()->json([
            'message' => 'Data berhasil diperbaharui.'
        ]);
    }

    public function apiDetailPt($id)
    {
        $tmPenghasilanAsetPt = Tm_penghasilan_aset_pt::where('tm_penghasilan_aset_id', $id)->get();

        return DataTables::of($tmPenghasilanAsetPt)
            ->addColumn('action', function ($p) {
                $btnEdit = "<a href='#' onclick='edit(" . $p->id . ")' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "</input><a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
