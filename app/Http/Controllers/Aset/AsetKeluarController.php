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
            'opd_id'    => 'required',
            'aset_id.*' => 'required',
            'ket'       => 'required'
        ]);
        $tmopd = Tmopd::findOrFail($request->opd_id);
        if ($request->hasFile('foto')) {
            $request->validate(['foto' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
            $foto = $request->file('foto');
            $nameFoto = rand() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('aset/opd', $nameFoto, 'sftp', 'public');
            $tmopd->image_network = $nameFoto;
            $tmopd->save();
        }

        foreach ($request->aset_id as $aset_id) {
            Tmopd_aset::create([
                'opd_id'        => $request->opd_id,
                'aset_id'       => $aset_id,
                'ket'           => $request->ket,
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
    public function show($tmopd_id)
    {
        $tmopd = Tmopd::find($tmopd_id);
        $tmasets = DB::table('tmasets')
            ->select('tmasets.id', 'tmasets.serial', 'tmasets.tahun', 'tmasets.jumlah', 'tmjenis_asets.n_jenis_aset', 'tmmerks.n_merk')
            ->join('tmjenis_asets', 'tmasets.jenis_aset_id', '=', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmasets.merk_id', '=', 'tmmerks.id')
            ->get();
        return view('aset.keluar.edit', compact(['tmopd_id', 'tmopd', 'tmasets']));
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
    public function destroyOpd($id)
    {
        Tmopd_aset::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyOpdAset($id)
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
            ->select('tmopds.id', 'tmopds.n_lokasi', 'tmopds.alamat', 'tmkategoris.n_kategori', 'tmopds.image_network')
            ->join('tmkategoris', 'tmopds.tmkategori_id', 'tmkategoris.id')
            ->join('tmopd_asets', 'tmopds.id', 'tmopd_asets.opd_id')
            ->orderBy('tmopds.id', 'asc')
            ->groupBy('tmopds.id')
            ->get();

        return DataTables::of($tmaset)
            ->addColumn('detail', function ($p) {
                return "<a href='#' onclick='showDetailAset(" . $p->id . ")' data-id='" . $p->id . "' title='Show Detail'><br/><i class='icon-eye mr-1'>Detail</i></a>";
            })
            ->addColumn('action', function ($p) {
                $tmopd_aset = Tmopd_aset::where('opd_id', $p->id)->count();
                $btnEdit = "<a href='" . route('aset.keluar.show', $p->id) . "' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a title='Hapus Aset'><i class='icon-remove'></i></a>";

                if ($tmopd_aset > 0) {
                    return $btnEdit . $btnRemove;
                } else {
                    // $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Aset'><i class='icon-remove'></i></a>";
                    return $btnEdit . $btnRemove;
                }
            })
            ->editColumn('foto', function ($p) {
                if ($p->image_network != "") {
                    return "<img onclick='showImageNetwork(this.src)'  src='" . config('app.SFTP_SRC') . 'aset/opd/' . $p->image_network . "' width='50px' alt='img' align='center'/>";
                }
            })
            ->rawColumns(['detail', 'action', 'foto'])
            ->toJson();
    }

    public function apiDetailAsetKeluar($tmopd_id)
    {
        $tmaset = DB::table('tmopd_asets')
            ->select('tmopd_asets.id', 'tmjenis_asets.n_jenis_aset', 'tmasets.no_aset', 'tmasets.serial', 'tmmerks.n_merk', 'tmopd_asets.ket', 'tmopd_asets.created_at')
            ->join('tmopds', 'tmopd_asets.opd_id', '=', 'tmopds.id')
            ->join('tmasets', 'tmopd_asets.aset_id', '=', 'tmasets.id')
            ->join('tmjenis_asets', 'tmasets.jenis_aset_id', '=', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmasets.merk_id', '=', 'tmmerks.id')
            ->where('tmopd_asets.opd_id', '=', $tmopd_id)
            ->get();

        return DataTables::of($tmaset)
            ->addColumn('action', function ($p) {
                $btnEdit = "<a href='#' onclick='edit(" . $p->id . ")' title='Edit Aset'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Aset'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->editColumn('created_at', function ($p) {
                return Carbon::parse($p->created_at)->format('d-m-Y');
            })
            ->rawColumns(['action'])
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
            'success'   => 1,
            'message' => $nameFoto
        ]);
    }
}
