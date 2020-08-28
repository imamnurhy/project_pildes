<?php

namespace App\Http\Controllers\Aset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\Tmaset_barang;
use App\Models\Tmaset_tanah;
use App\Models\Tmasets;
use App\Models\Tmberkas;
use App\Models\Tmberkas_aset_tanah;
use App\Models\Tmjenis_aset;
use App\Models\Tmmerk;
use App\Models\Tmno_urut;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
                'provinsi_id'   => 'required',
                'kota_id'       => 'required',
                'kecamatan_id'  => 'required',
                'kelurahan_id'  => 'required',
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
                            $file->storeAs('aset/tanah/berkas/'.$request->id_master_aset, $name_file, 'sftp', 'public');

                            $berkas_aset[$key2] = $name_file;
                        }
                    }
                    Tmberkas_aset_tanah::create([
                        "id_master_aset" => $request->id_master_aset,
                        "tmberkas_id" => $berkas,
                        "no_sertifikat" => $request->no_sertifikat[$key],
                        "nm_pemegang_hak" =>$request->nm_pemegang_hak[$key],
                        "tgl_berakhir_hak" => $request->tgl_berakhir_hak[$key],
                        "nib" =>$request->nib[$key],
                        "berkas" =>$berkas_aset[$key],
                    ]);
                }
            }
        } else {
            $request->validate([
                'nomor'           => 'required',
                'merk'            => 'required',
                'jenis'            => 'required',
                'tahun_pembuatan' => 'required',
                'no_rangka'       => 'required',
                'no_mesin'        => 'required',
            ]);
            
            $tmaset_barang = Tmaset_barang::firstOrCreate([
                'id_master_aset'  => $request->id_master_aset
            ]);
            $tmaset_barang->update([
                'nomor'           => $request->nomor,
                'merk'            => $request->merk,
                'jenis'           => $request->jenis,
                'tahun_pembuatan' => $request->tahun_pembuatan,
                'no_rangka'       => $request->no_rangka,
                'no_mesin'        => $request->no_mesin,
                
            ]);
        }



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
                'tmmaster_asset.pemilik_sebelumnya',
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
        $data = Tmaset_barang::where('id_master_aset', '=', $tmmaster_asset->tmmaster_asset_id)->first();
        $tbl_berkas = [];
        if ($tmmaster_asset->kode == 'tanah') {
            $formEdit = 1;
            $data = Tmaset_tanah::where('id_master_aset', '=', $tmmaster_asset->tmmaster_asset_id)->first();
            $tbl_berkas = Tmberkas_aset_tanah::where('id_master_aset', '=', $tmmaster_asset->tmmaster_asset_id)->with(['tmberkas'])->get();
        }
        // dd($tbl_berkas);
        $provinsis = Provinsi::select('id', 'kode', 'n_provinsi')->get();
        $tmberkas = Tmberkas::where('tmjenis_aset_id', '=', $tmmaster_asset->tmjenis_asets_id)->get();

  
        // dd($tbl_berkas);
        return view('aset.masuk.show', compact(['tmmaster_asset', 'formEdit', 'provinsis','tmberkas','data','tbl_berkas']));
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


    public function api(Request $request)
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
                'tmjenis_asets.n_jenis_aset',
                'tmmerks.n_merk'
            )
            ->join('tmjenis_asets', 'tmmaster_asset.id_jenis_asset', '=', 'tmjenis_asets.id')
            ->join('tmperolehan', 'tmmaster_asset.id_tmperolehan', '=', 'tmperolehan.id')
            ->join('trmaster_dokumen', 'tmmaster_asset.id', 'trmaster_dokumen.id_master')
            ->join('tmmerks', 'tmmaster_asset.id_rincian_jenis_asset', 'tmmerks.id')
            ->groupBy('tmmaster_asset.id');

        // if ($request->id_jenis_aset != 99) {
        //     $tmaset->where('tmmaster_asset.id_jenis_asset', $request->id_jenis_aset);
        // }

        if ($request->id_rincian_jenis_aset != '') {
            $tmaset->where('tmmaster_asset.id_rincian_jenis_asset', $request->id_rincian_jenis_aset);
        }

        if ($request->status != 99) {
            $tmaset->where('tmmaster_asset.status', $request->status);
        }

        if ($request->id_dokumen != 99) {
            $tmaset->where('trmaster_dokumen.id_dokumen', $request->id_dokumen);
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

    public function download_berkas($file)
    {
        $tmberkas_aset_tanah  = Tmberkas_aset_tanah::where('berkas', '=', $file)->first();
        $tmaset_tanah = Tmaset_tanah::where('tanda_bukti', '=', $file)->orWhere('file_bukti_beli', '=', $file)->first();
        if ($tmberkas_aset_tanah) {
            $path = 'aset/tanah/berkas/'.$tmberkas_aset_tanah->id_master_aset.'/';
        }

        if ($tmaset_tanah) {
            $path = 'aset/tanah/';
        }

        $exists = Storage::disk('sftp')->exists($path.$file);

        // dd($exists);
        if ($exists) {
            return Storage::disk('sftp')->download($path.$file, );
        }

        return redirect()->to('/');
    }
}
