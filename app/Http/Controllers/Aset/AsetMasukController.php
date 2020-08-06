<?php

namespace App\Http\Controllers\Aset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\Tmasets;
use App\Models\Tmjenis_aset;
use App\Models\Tmmerk;
use App\Models\Tmno_urut;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AsetMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('aset.masuk.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = 0;
        $tmjenis_asets = Tmjenis_aset::all();
        $tmmerks = Tmmerk::all();
        $tmperolehans = DB::table('tmperolehan')->get();
        $tmdokumens = DB::table('tmdokumen')->get();
        return view('aset.masuk.form', compact(['id', 'tmjenis_asets', 'tmmerks', 'tmperolehans', 'tmdokumens']));
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
            'date'                   => 'required',
            'id_jenis_asset'         => 'required',
            'id_rincian_jenis_asset' => 'required',
            'id_tmperolehan'         => 'required',
            'pemilik_sebelumnya'     => 'required',
            'harga_beli'             => 'required',
            'tahun'                  => 'required',
            'status'                 => 'required',
            'kondisi'                => 'required',
            'id_dokumen'             => 'required'
        ]);

        $tmmaster_asset_id =  DB::table('tmmaster_asset')->insertGetId([
            'date'                   => $request->date,
            'id_jenis_asset'         => $request->id_jenis_asset,
            'id_rincian_jenis_asset' => $request->id_rincian_jenis_asset,
            'id_tmperolehan'         => $request->id_tmperolehan,
            'pemilik_sebelumnya'     => $request->pemilik_sebelumnya,
            'harga_beli'             => $request->harga_beli,
            'tahun'                  => $request->tahun,
            'status'                 => $request->status,
            'kondisi'                => $request->kondisi,
            'user'                   => Auth::user()->id,
            'created_at'             => Carbon::now()
        ]);

        foreach ($request->id_dokumen as $id_dokumen) {
            DB::table('trmaster_dokumen')->insert([
                'id_master' => $tmmaster_asset_id,
                'id_dokumen' => $id_dokumen
            ]);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function storeDetailTanah(Request $request)
    {
        $request->validate([
            'nm_lahan' => 'required',
            'luas' => 'required',
            'alamat' => 'required',
            'batas_barat' => 'required',
            'batas_timur' => 'required',
            'batas_selatan' => 'required',
            'batas_utara' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'longitude' => 'required',
            'provinsi_id' => 'required',
            'kota_id' => 'required',
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
        ]);



        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tmjenis_asets = Tmjenis_aset::all();
        $tmmerks = Tmmerk::all();
        $tmperolehans = DB::table('tmperolehan')->get();
        $tmdokumens = DB::table('tmdokumen')->get();
        return view('aset.masuk.form', compact(['id', 'tmjenis_asets', 'tmmerks', 'tmperolehans', 'tmdokumens']));
    }

    public function showDetail($id)
    {
        $tmmaster_asset = DB::table('tmmaster_asset')
            ->select(
                'tmmaster_asset.id as tmmaster_asset_id',
                'tmjenis_asets.id as tmjenis_asets_id',
                'tmjenis_asets.n_jenis_aset',
                'tmjenis_asets.kode',
                'tmmerks.n_merk'
            )
            ->join('tmjenis_asets', 'tmmaster_asset.id_jenis_asset', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmmaster_asset.id_rincian_jenis_asset', 'tmmerks.id')
            ->where('tmmaster_asset.id', $id)
            ->first();

        // dd($tmmaster_asset);

        $formEdit = 0;
        if ($tmmaster_asset->kode == 'tanah') {
            $formEdit = 1;
        }
        $provinsis = Provinsi::select('id', 'kode', 'n_provinsi')->get();


        return view('aset.masuk.show', compact(['tmmaster_asset', 'formEdit', 'provinsis']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tmmaster_asset = DB::table('tmmaster_asset')
            ->select('*')
            ->join('trmaster_dokumen', 'tmmaster_asset.id', '=', 'trmaster_dokumen.id_master')
            ->where('tmmaster_asset.id', '=', $id)
            ->first();
        $id_dokumen = DB::table('trmaster_dokumen')->where('id_master', $id)->pluck('id_dokumen')->toArray();

        return response()->json([
            'id'                     => $tmmaster_asset->id,
            'date'                   => Carbon::parse($tmmaster_asset->date)->format('Y-m-d'),
            'id_jenis_asset'         => $tmmaster_asset->id_jenis_asset,
            'id_rincian_jenis_asset' => $tmmaster_asset->id_rincian_jenis_asset,
            'id_tmperolehan'         => $tmmaster_asset->id_tmperolehan,
            'pemilik_sebelumnya'     => $tmmaster_asset->pemilik_sebelumnya,
            'harga_beli'             => $tmmaster_asset->harga_beli,
            'tahun'                  => $tmmaster_asset->tahun,
            'status'                 => $tmmaster_asset->status,
            'kondisi'                => $tmmaster_asset->kondisi,
            'id_dokumen'             => $id_dokumen,
        ]);
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
            'date'                   => 'required',
            'id_jenis_asset'         => 'required',
            'id_rincian_jenis_asset' => 'required',
            'id_tmperolehan'         => 'required',
            'pemilik_sebelumnya'     => 'required',
            'harga_beli'             => 'required',
            'tahun'                  => 'required',
            'status'                 => 'required',
            'kondisi'                => 'required',
            'id_dokumen'             => 'required'
        ]);

        DB::table('tmmaster_asset')
            ->where('id', $id)
            ->update([
                'date'                   => $request->date,
                'id_jenis_asset'         => $request->id_jenis_asset,
                'id_rincian_jenis_asset' => $request->id_rincian_jenis_asset,
                'id_tmperolehan'         => $request->id_tmperolehan,
                'pemilik_sebelumnya'     => $request->pemilik_sebelumnya,
                'harga_beli'             => $request->harga_beli,
                'tahun'                  => $request->tahun,
                'status'                 => $request->status,
                'kondisi'                => $request->kondisi,
                'id_dokumen'             => $request->id_dokumen,
                'user'                   => Auth::user()->id,
                'updated_at'             => Carbon::now()
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
        DB::table('tmmaster_asset')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function getMerk($id_nama_aset)
    {
        return Tmmerk::select('id', 'n_merk', 'id_nama_aset')->where('id_nama_aset', $id_nama_aset)->get();
    }


    public function api()
    {
        $tmaset = DB::table('tmmaster_asset')
            ->select(
                'tmmaster_asset.id',
                'tmmaster_asset.date',
                'tmperolehan.nm_pembelian',
                'tmmaster_asset.pemilik_sebelumnya',
                'tmmaster_asset.harga_beli',
                'tmmaster_asset.tahun',
                'tmmaster_asset.status',
                'tmmaster_asset.kondisi',
            )
            ->join('tmjenis_asets', 'tmmaster_asset.id_jenis_asset', '=', 'tmjenis_asets.id')
            ->join('tmperolehan', 'tmmaster_asset.id_tmperolehan', '=', 'tmperolehan.id')
            ->get();

        return DataTables::of($tmaset)
            ->addColumn('action', function ($p) {
                $btnEdit = "<a href='" . route('aset.masuk.show', $p->id) . "' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->editColumn('date', function ($p) {
                return Carbon::parse($p->date)->format('Y-m-d');
            })
            ->editColumn('status', function ($p) {
                $txt = '';
                if ($p->status == 1) {
                    $txt = 'Masih Ada';
                } else {
                    $txt = 'Tidak Ada';
                }
                return $txt;
            })
            ->addColumn('detail', function ($p) {
                return "<a href='" . route('aset.masuk.showDetail', $p->id) . "' title='Show Detail Aset'><i class='icon-eye mr-1'></i></a>";
            })
            ->rawColumns(['action', 'detail'])
            ->toJson();
    }

    public function getKabupaten($provinsi_id)
    {
        return Kabupaten::select('id', 'kode', 'n_kabupaten')->whereprovinsi_id($provinsi_id)->get();
    }

    public function getKecamatan($kabupaten_id)
    {
        return Kecamatan::select('id', 'kode', 'n_kecamatan')->wherekabupaten_id($kabupaten_id)->get();
    }

    public function getKelurahan($kelurahan_id)
    {
        return Kelurahan::select('id', 'kode', 'n_kelurahan')->wherekecamatan_id($kelurahan_id)->get();
    }


    /**
     * GenerateNoAset
     *
     * @param Request $request
     * @return void
     */
    public function generateNoAset(Request $request)
    {
        /**
         * Generage nomor aset
         * * id jenis aset
         * * id merek
         * * Bulan dan tahun waktu pembuatan
         * * nomor urut sesuai dengan id jenis aset di tambah 4 angka nol di depan nomor urut
         * Example
         * 11072000001
         */

        $tmno_urut = Tmno_urut::where('tmjenis_aset_id', $request->jenis_aset_id)->first();
        $jenis_aset_id = $request->jenis_aset_id;
        $merk_id = $request->merk_id;
        $monthYear = Carbon::now()->format('my');
        $no_urut = 1;
        $no_aset = $jenis_aset_id . $merk_id . $monthYear;

        if ($tmno_urut == null) {
            $tmno_urut =  Tmno_urut::create([
                'tmjenis_aset_id' => $jenis_aset_id,
                'no_urut'         => $no_urut,
                'tahun'           => Carbon::now()->format('Y'),
            ]);
        }

        $tmasets = Tmasets::where('jenis_aset_id', $jenis_aset_id)->get();
        foreach ($tmasets as $tmaset) {

            if (sprintf('%04s', $tmno_urut->no_urut) == sprintf('%04s', substr($tmaset->no_aset, -4))) {
                $no_urut = $tmno_urut->no_urut + 1;
            } else {
                $no_urut = $tmno_urut->no_urut;
            }

            if (Carbon::now()->format('Y') != $tmno_urut->tahun) {
                $no_urut = 1;
            }

            $tmno_urut->no_urut =  $no_urut;
            $tmno_urut->save();
        }






        return $no_aset . sprintf('%04s', $no_urut);
    }
}
