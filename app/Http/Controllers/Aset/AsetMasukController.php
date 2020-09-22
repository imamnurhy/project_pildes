<?php

namespace App\Http\Controllers\Aset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\Tm_asset_kendaraan;
use App\Models\Tmaset_barang;
use App\Models\Tmaset_tanah;
use App\Models\Tmasets;
use App\Models\Tmberkas;
use App\Models\Tmberkas_aset_tanah;
use App\Models\Tmjenis_aset;
use App\Models\Tmjenis_aset_rincian;
use App\Models\Tmmerk;
use App\Models\Tmno_urut;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use PDF;

class AsetMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tmjenis_asets = Tmjenis_aset::all();
        $tmdokumens = DB::table('tmdokumen')->get();

        return view('aset.masuk.index', compact(['tmjenis_asets', 'tmdokumens']));
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
            'no_pendaftaran'         => 'required',
            'id_jenis_asset'         => 'required',
            'id_rincian_jenis_asset' => 'required',
            'nilai'             => 'required',
            'tahun'                  => 'required',
        ]);

        DB::table('tmmaster_asset')->insert([
            'date'                   => $request->date,
            'no_pendaftaran'         => $request->no_pendaftaran,
            'id_jenis_asset'         => $request->id_jenis_asset,
            'id_rincian_jenis_asset' => $request->id_rincian_jenis_asset,
            'nilai'                  => $request->nilai,
            'tahun'                  => $request->tahun,
            'user'                   => Auth::user()->id,
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

    public function hapusBerkas($id)
    {
        Tmberkas_aset_tanah::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
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
        $tmmaster_asset = DB::table('tmmaster_asset')
            ->select('*')
            ->where('tmmaster_asset.id', '=', $id)
            ->first();

        return response()->json([
            'id'                     => $tmmaster_asset->id,
            'date'                   => Carbon::parse($tmmaster_asset->date)->format('Y-m-d'),
            'id_jenis_asset'         => $tmmaster_asset->id_jenis_asset,
            'id_rincian_jenis_asset' => $tmmaster_asset->id_rincian_jenis_asset,
            'nilai'                  => $tmmaster_asset->nilai,
            'tahun'                  => $tmmaster_asset->tahun,
            'no_pendaftaran'         => $tmmaster_asset->no_pendaftaran,
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
            'no_pendaftaran'         => 'required',
            'id_jenis_asset'         => 'required',
            'id_rincian_jenis_asset' => 'required',
            'nilai'                  => 'required',
            'tahun'                  => 'required',
        ]);

        DB::table('tmmaster_asset')
            ->where('id', $id)
            ->update([
                'date'                   => $request->date,
                'no_pendaftaran'         => $request->no_pendaftaran,
                'id_jenis_asset'         => $request->id_jenis_asset,
                'id_rincian_jenis_asset' => $request->id_rincian_jenis_asset,
                'nilai'                  => $request->nilai,
                'tahun'                  => $request->tahun,
                'user'                   => Auth::user()->id,
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

    public function destroyAssetKendaraan($id)
    {
        Tm_asset_kendaraan::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function getRincian($id)
    {
        return Tmjenis_aset_rincian::where('tmjenis_aset_id', $id)->get();
    }


    public function api(Request $request)
    {
        $tmaset = DB::table('tmmaster_asset')
            ->select(
                'tmmaster_asset.id',
                'tmmaster_asset.date',
                'tmmaster_asset.pemilik_sebelumnya',
                'tmmaster_asset.nilai',
                'tmmaster_asset.tahun',
                'tmmaster_asset.status',
                'tmmaster_asset.kondisi',
                'tmjenis_asets.n_jenis_aset',
                'tmjenis_aset_rincians.n_rincian'
            )
            ->join('tmjenis_asets', 'tmmaster_asset.id_jenis_asset', '=', 'tmjenis_asets.id')

            ->join('tmjenis_aset_rincians', 'tmmaster_asset.id_rincian_jenis_asset', 'tmjenis_aset_rincians.id')
            ->groupBy('tmmaster_asset.id');

        if ($request->id_jenis_aset != 99) {
            $tmaset->where('tmmaster_asset.id_jenis_asset', $request->id_jenis_aset);
        }

        if ($request->id_rincian_jenis_aset != '') {
            $tmaset->where('tmmaster_asset.id_rincian_jenis_asset', $request->id_rincian_jenis_aset);
        }

        return DataTables::of($tmaset)
            ->addColumn('action', function ($p) {
                $btnEdit = "<a href='" . route('aset.masuk.show', $p->id) . "' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->editColumn('date', function ($p) {
                return Carbon::parse($p->date)->format('Y-m-d');
            })
            ->addColumn('detail', function ($p) {
                return "<a href='" . route('aset.masuk.detail.show', $p->id) . "' title='Show Detail Aset'><i class='icon-eye mr-1'></i></a>";
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

    public function download_berkas($file)
    {
        $tmberkas_aset_tanah  = Tmberkas_aset_tanah::where('berkas', '=', $file)->first();
        $tmaset_tanah = Tmaset_tanah::where('tanda_bukti', '=', $file)->orWhere('file_bukti_beli', '=', $file)->first();
        if ($tmberkas_aset_tanah) {
            $path = 'aset/tanah/berkas/' . $tmberkas_aset_tanah->id_master_aset . '/';
        }

        if ($tmaset_tanah) {
            $path = 'aset/tanah/';
        }

        $exists = Storage::disk('sftp')->exists($path . $file);

        // dd($exists);
        if ($exists) {
            return Storage::disk('sftp')->download($path . $file);
        }

        return redirect()->to('/');
    }


    // Detail asset
    public function showDetail($id)
    {
        $tmmaster_asset = DB::table('tmmaster_asset')
            ->select(
                'tmmaster_asset.id as tmmaster_asset_id',
                'tmmaster_asset.pemilik_sebelumnya',
                'tmjenis_asets.id as tmjenis_asets_id',
                'tmjenis_asets.n_jenis_aset',
                'tmjenis_asets.kode',
                'tmjenis_aset_rincians.n_rincian'
            )
            ->join('tmjenis_asets', 'tmmaster_asset.id_jenis_asset', 'tmjenis_asets.id')
            ->join('tmjenis_aset_rincians', 'tmmaster_asset.id_rincian_jenis_asset', 'tmjenis_aset_rincians.id')
            ->where('tmmaster_asset.id', $id)
            ->first();

        // dd($tmmaster_asset);

        $formEdit = 0;
        $data = [];
        $tbl_berkas = [];
        $tmAssetKendaraans = [];
        $tmaset_barangs = [];
        if ($tmmaster_asset->kode == 'tanah') {
            $formEdit = 1;
            $data = Tmaset_tanah::where('id_master_aset', '=', $tmmaster_asset->tmmaster_asset_id)->first();
            $tbl_berkas = Tmberkas_aset_tanah::where('id_master_aset', '=', $tmmaster_asset->tmmaster_asset_id)
                ->with(['tmberkas'])->get();
        } else if ($tmmaster_asset->kode == 'kendaraan') {
            $formEdit = 2;
            $tmAssetKendaraans = Tm_asset_kendaraan::where('tmmaster_asset_id', $id)->get();
        } else if ($tmmaster_asset->kode == 'barang') {
            $formEdit = 3;
            $tmaset_barangs = Tmaset_barang::where('id_master_aset', '=', $tmmaster_asset->tmmaster_asset_id)->get();
        }

        $provinsis = Provinsi::select('id', 'kode', 'n_provinsi')->get();
        $tmberkas = Tmberkas::where('tmjenis_aset_id', '=', $tmmaster_asset->tmjenis_asets_id)->get();

        return view('aset.masuk.show', compact(
            'tmmaster_asset',
            'formEdit',
            'provinsis',
            'tmberkas',
            'data',
            'tbl_berkas',
            'tmAssetKendaraans',
            'tmaset_barangs'
        ));
    }

    public function storeDetail(Request $request)
    {
        /**
         * Form edit
         * 1 = tanah
         * 2 = kendaraan
         */
        if ($request->form_edit == 1) {
            $request->validate([
                'nm_lahan'      => 'required',
                'luas'          => 'required',
                'alamat'        => 'required',
                'batas_barat'   => 'required',
                'batas_timur'   => 'required',
                'batas_selatan' => 'required',
                'batas_utara'   => 'required',
                'latitude'      => 'required',
                'longitude'     => 'required',
                'longitude'     => 'required',
                // 'provinsi_id'   => 'required',
                // 'kota_id'       => 'required',
                // 'kecamatan_id'  => 'required',
                // 'kelurahan_id'  => 'required',
                'luas_tanah'    => 'required',
                'berkas.*' => 'mimes:doc,pdf,docx,jpg,jpeg,png'
            ]);

            if ($request->hasFile('tanda_bukti')) {
                $file = $request->file('tanda_bukti');
                $tanda_bukti = rand() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('aset/tanah', $tanda_bukti, 'sftp', 'public');
            } else {
                $tanda_bukti = $request->tanda_bukti_db;
            }


            if ($request->hasFile('file_bukti_beli')) {
                $file = $request->file('file_bukti_beli');
                $file_bukti_beli = rand() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('aset/tanah', $file_bukti_beli, 'sftp', 'public');
            } else {
                $file_bukti_beli = $request->file_bukti_beli_db;
            }

            $tmaset_tanah = Tmaset_tanah::firstOrCreate([
                'id_master_aset'  => $request->id_master_aset,
            ]);

            $tmaset_tanah->update([
                'id_master_aset'  => $request->id_master_aset,
                'nm_lahan'        => $request->nm_lahan,
                'luas'            => $request->luas,
                'alamat'          => $request->alamat,
                'batas_barat'     => $request->batas_barat,
                'batas_timur'     => $request->batas_timur,
                'batas_selatan'   => $request->batas_selatan,
                'batas_utara'     => $request->batas_utara,
                'id_jenis_tanah'  => $request->id_jenis_tanah,
                'latitude'        => $request->latitude,
                'longitude'       => $request->longitude,
                'longitude'       => $request->longitude,
                'provinsi_id'     => $request->provinsi_id,
                'kota_id'         => $request->kota_id,
                'kecamatan_id'    => $request->kecamatan_id,
                'kelurahan_id'    => $request->kelurahan_id,
                'luas_tanah'      => $request->luas_tanah,
                'nm_pemilik_sebelum' => $request->nm_pemilik_sebelum,
                'tanda_bukti'     => $tanda_bukti,
                'file_bukti_beli' => $file_bukti_beli
            ]);

            // dd($request->no_sertifikat);
            // exit;
            foreach ($request->tmberkas_id as $key => $berkas) {
                if ($berkas) {
                    if ($request->hasfile('berkas')) {
                        foreach ($request->file('berkas') as $key2 => $file) {
                            $name_file = rand() . '.' . $file->getClientOriginalExtension();
                            $file->storeAs('aset/tanah/berkas/' . $request->id_master_aset, $name_file, 'sftp', 'public');

                            $berkas_aset[$key2] = $name_file;
                        }
                    }
                    Tmberkas_aset_tanah::create([
                        "id_master_aset" => $request->id_master_aset,
                        "tmberkas_id" => $berkas,
                        "no_sertifikat" => $request->no_sertifikat[$key],
                        "nm_pemegang_hak" => $request->nm_pemegang_hak[$key],
                        "tgl_berakhir_hak" => $request->tgl_berakhir_hak[$key],
                        "nib" => $request->nib[$key],
                        "berkas" => $berkas_aset[$key],
                    ]);
                }
            }
        } else if ($request->form_edit == 2) {
            $request->validate([
                'no_polisi'     => 'required',
                'merek'         => 'required',
                'no_stnk'       => 'required',
                'nm_pemilik'    => 'required',
                'sumber_barang' => 'required',
                'nilai'         => 'required',
            ]);

            Tm_asset_kendaraan::create([
                'tmmaster_asset_id' => $request->id_master_aset,
                'no_polisi'         => $request->no_polisi,
                'merek'             => $request->merek,
                'no_stnk'           => $request->no_stnk,
                'nm_pemilik'        => $request->nm_pemilik,
                'sumber_barang'     => $request->sumber_barang,
                'nilai'             => $request->nilai,
            ]);
        } else if ($request->form_edit == 3) {
            $request->validate([
                'nomor'           => 'required',
                'merk'            => 'required',
                'jenis'           => 'required',
                'tahun_pembuatan' => 'required',
                'no_rangka'       => 'required',
                'no_mesin'        => 'required',
            ]);

            Tmaset_barang::create([
                'nomor'           => $request->nomor,
                'merk'            => $request->merk,
                'jenis'           => $request->jenis,
                'tahun_pembuatan' => $request->tahun_pembuatan,
                'no_rangka'       => $request->no_rangka,
                'no_mesin'        => $request->no_mesin,
                'id_master_aset'  => $request->id_master_aset
            ]);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function editDetail(Request $request, $id)
    {
        if ($request->form_edit == 1) {
            // return Tmaset_barang::find($id);
        } else if ($request->form_edit == 2) {
            return Tm_asset_kendaraan::find($id);
        } else if ($request->form_edit == 3) {
            return Tmaset_barang::find($id);
        }
    }

    public function updateDetail(Request $request, $id)
    {
        /**
         * form edit
         * 1 = tanah
         * 2 = kendaraan
         * 3 = barang
         */
        if ($request->form_edit == 1) {
            /*code */
        } else if ($request->form_edit == 2) {
            $request->validate([
                'no_polisi'     => 'required',
                'no_stnk'       => 'required',
                'merek'         => 'required',
                'nm_pemilik'    => 'required',
                'sumber_barang' => 'required',
                'nilai'         => 'required',
            ]);

            $tmAssetKendaraan = Tm_asset_kendaraan::find($id);

            $tmAssetKendaraan->update([
                'no_polisi' => $request->no_polisi,
                'no_stnk' => $request->no_stnk,
                'merek' => $request->merek,
                'nm_pemilik' => $request->nm_pemilik,
                'sumber_barang' => $request->sumber_barang,
                'nilai' => $request->nilai,
            ]);
        } else if ($request->form_edit == 3) {
            $request->validate([
                'nomor'           => 'required',
                'merk'            => 'required',
                'jenis'           => 'required',
                'tahun_pembuatan' => 'required',
                'no_rangka'       => 'required',
                'no_mesin'        => 'required',
            ]);

            $tmAsetBarang = Tmaset_barang::find($id);

            $tmAsetBarang->update([
                'nomor'           => $request->nomor,
                'merk'            => $request->merk,
                'jenis'           => $request->jenis,
                'tahun_pembuatan' => $request->tahun_pembuatan,
                'no_rangka'       => $request->no_rangka,
                'no_mesin'        => $request->no_mesin,
                'id_master_aset'  => $request->id_master_aset
            ]);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Data berhasil diperbaharui.'
        ]);
    }

    public function destroyDetail(Request $request, $id)
    {

        if ($request->form_edit == 2) {
            Tm_asset_kendaraan::destroy($id);
        } else if ($request->form_edit == 3) {
            Tmaset_barang::destroy($id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function laporanPdf(Request $request)
    {
        $tmaset = DB::table('tmmaster_asset')
            ->select(
                'tmmaster_asset.id',
                'tmmaster_asset.date',
                'tmmaster_asset.pemilik_sebelumnya',
                'tmmaster_asset.nilai',
                'tmmaster_asset.tahun',
                'tmmaster_asset.status',
                'tmmaster_asset.kondisi',
                'tmjenis_asets.n_jenis_aset',
                'tmjenis_aset_rincians.n_rincian'
            )
            ->join('tmjenis_asets', 'tmmaster_asset.id_jenis_asset', '=', 'tmjenis_asets.id')

            ->join('tmjenis_aset_rincians', 'tmmaster_asset.id_rincian_jenis_asset', 'tmjenis_aset_rincians.id')
            ->groupBy('tmmaster_asset.id');

        if ($request->id_jenis_aset != 99) {
            $tmaset->where('tmmaster_asset.id_jenis_asset', $request->id_jenis_aset)->get();
        } else         if ($request->id_rincian_jenis_aset != '') {
            $tmaset->where('tmmaster_asset.id_rincian_jenis_asset', $request->id_rincian_jenis_aset)->get();
        } else {
            $tmaset->get();
        }

        $pdf = PDF::loadview('aset.masuk.report_pdf', ['tmasets' => $tmaset]);
        // return $pdf->download('laporan_pendapatan');
        return $pdf->stream();
    }
}
