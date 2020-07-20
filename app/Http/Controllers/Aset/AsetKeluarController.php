<?php

namespace App\Http\Controllers\Aset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tmopd;
use App\Models\Tmopd_aset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AsetKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('aset.keluar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tmopds = Tmopd::all();
        $tmasets = DB::table('tmasets')
            ->select('tmasets.id', 'tmasets.serial', 'tmasets.tahun', 'tmasets.jumlah', 'tmjenis_asets.n_jenis_aset', 'tmmerks.n_merk')
            ->join('tmjenis_asets', 'tmasets.jenis_aset_id', '=', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmasets.merk_id', '=', 'tmmerks.id')
            ->get();
        return view('aset.keluar.add', compact(['tmopds', 'tmasets']));
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
            'opd_id'  => 'required',
            'aset_id.*' => 'required',
            'ket'     => 'required'
        ]);

        foreach ($request->aset_id as $aset_id) {
            Tmopd_aset::create([
                'opd_id'  => $request->opd_id,
                'aset_id' => $aset_id,
                'ket'     => $request->ket,
                'created_by'    => Auth::user()->pegawai->n_pegawai,
                'created_at'    => Carbon::now(),
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
        $tmopds = Tmopd::all();
        $tmasets = DB::table('tmasets')
            ->select('tmasets.id', 'tmasets.serial', 'tmasets.tahun', 'tmasets.jumlah', 'tmjenis_asets.n_jenis_aset', 'tmmerks.n_merk')
            ->join('tmjenis_asets', 'tmasets.jenis_aset_id', '=', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmasets.merk_id', '=', 'tmmerks.id')
            ->get();
        return view('aset.keluar.edit', compact(['id', 'tmopds', 'tmasets']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tmopd_aset = Tmopd_aset::find($id);
        return response()->json($tmopd_aset);
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
        // $request->validate([
        //     'opd_id'  => 'required',
        //     'aset_id' => 'required',
        //     'ket'     => 'required'
        // ]);

        // $tmopd_aset = Tmopd_aset::find($id);

        // $tmopd_aset->update([
        //     'opd_id'     => $request->opd_id,
        //     'aset_id'    => $request->aset_id,
        //     'ket'        => $request->ket,
        //     'updated_by' => Auth::user()->pegawai->n_pegawai,
        //     'updated_at' => Carbon::now(),
        // ]);

        // return response()->json([
        //     'success' => 1,
        //     'message' => 'Data berhasil diperbaharui.'
        // ]);

        #region update asset in menu detail
        $tmopd_aset = Tmopd_aset::find($id);

        $tmopd_aset->update([
            'opd_id'     => $request->opd_id,
            'aset_id'    => $request->aset_id,
            'ket'        => $request->ket,
            'updated_by' => Auth::user()->pegawai->n_pegawai,
            'updated_at' => Carbon::now(),
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
        Tmopd_aset::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }


    /**
     * Show detail aset keluar
     *
     * @return \Iluminate\Http\Response
     */
    public function showDetail($tmopd_id)
    {
        $tmopd = Tmopd::with('tmkategoris')->find($tmopd_id);
        $tmasets = DB::table('tmasets')
            ->select('tmasets.id', 'tmasets.serial', 'tmasets.tahun', 'tmasets.jumlah', 'tmjenis_asets.n_jenis_aset', 'tmmerks.n_merk')
            ->join('tmjenis_asets', 'tmasets.jenis_aset_id', '=', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmasets.merk_id', '=', 'tmmerks.id')
            ->get();
        return view('aset.keluar.showDetail', compact('tmopd_id', 'tmopd', 'tmasets'));
    }

    public function api()
    {
        $tmaset = DB::table('tmopds')
            ->select('tmopds.id', 'tmopds.n_lokasi', 'tmopds.alamat', 'tmkategoris.n_kategori', 'tmopds.foto')
            ->join('tmkategoris', 'tmopds.tmkategori_id', 'tmkategoris.id')
            ->orderBy('tmopds.id', 'asc')
            ->get();

        return DataTables::of($tmaset)
            ->addColumn('action', function ($p) {
                return "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Aset'><i class='icon-remove'></i></a>";
            })
            ->addColumn('detail', function ($p) {
                return "<a href='" . route('aset.keluar.showDetail', $p->id) . "' title='Show Detail'><i class='icon-eye mr-1'></i></a>";
            })
            ->editColumn('foto', function ($p) {
                if ($p->foto == "") {
                    $img = "Tidak";
                } else {
                    $img = "<img src='" . config('app.SFTP_SRC') . 'opd/' . $p->foto . "' width='50px' alt='img' align='center'/>";
                }
                return $img . "<br/><a onclick='editFoto(" . $p->id . ")' href='javascript:;' data-fancybox data-src='#formUpload' data-modal='true' title='Upload foto' class='btn btn-xs'>Unggah Foto <i class='icon-upload'></i></a>";
            })
            ->rawColumns(['foto', 'detail', 'action'])
            ->toJson();
    }

    public function apiDetailAsetKeluar($tmopd_id)
    {
        $tmaset = DB::table('tmopd_asets')
            ->select('tmopd_asets.id', 'tmjenis_asets.n_jenis_aset', 'tmasets.serial', 'tmmerks.n_merk', 'tmopd_asets.ket', 'tmopd_asets.created_at')
            ->join('tmopds', 'tmopd_asets.opd_id', '=', 'tmopds.id')
            ->join('tmasets', 'tmopd_asets.aset_id', '=', 'tmasets.id')
            ->join('tmjenis_asets', 'tmasets.jenis_aset_id', '=', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmasets.merk_id', '=', 'tmmerks.id')
            ->where('tmopd_asets.opd_id', '=', $tmopd_id)
            ->get();

        return DataTables::of($tmaset)
            ->addColumn('action', function ($p) {
                return "
                <a href='#' onclick='edit(" . $p->id . ")' title='Edit Aset'><i class='icon-pencil mr-1'></i></a>
                <a class='text-danger' title='Hapus Aset'><i class='icon-remove'></i></a>";
            })
            ->editColumn('created_at', function ($p) {
                return Carbon::parse($p->created_at)->format('d-m-Y');
            })
            ->rawColumns(['action', 'created_at'])
            ->toJson();
    }

    //--- Foto
    public function updateFoto(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $tmopd = Tmopd::findOrFail($id);
        $lastFoto = $tmopd->foto;
        $foto = $request->file('foto');
        $nameFoto = rand() . '.' . $foto->getClientOriginalExtension();
        $foto->storeAs('opd', $nameFoto, 'sftp', 'public');
        $tmopd->foto = $nameFoto;
        $tmopd->save();

        if ($lastFoto != '') {
            Storage::disk('sftp')->delete('foto/' . $lastFoto);
        }

        return response()->json([
            'success'   => true,
            'message' => $nameFoto
        ]);
    }
}
