<?php

namespace App\Http\Controllers\Aset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        return view('aset.masuk.form', compact(['id', 'tmjenis_asets', 'tmmerks']));
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
            'tgl'           => 'required',
            'jenis_aset_id' => 'required',
            'serial'        => 'required',
            'merk_id'       => 'required',
            'tahun'         => 'required',
            'kondisi'       => 'required',
            'jumlah'        => 'required',
            'status'        => 'required'
        ]);

        $tmno_urut = Tmno_urut::where('tmjenis_aset_id', $request->jenis_aset_id)->first();
        $no_urut = 0;
        if ($tmno_urut != null) {
            $tmno_urut->update([
                'no_urut' => $tmno_urut->no_urut + 1,
            ]);
            $no_urut = sprintf('%04s', $tmno_urut->no_urut);
        } else {
            $a = Tmno_urut::create([
                'tmjenis_aset_id' => $request->jenis_aset_id,
                'no_urut' => 1
            ]);
            $no_urut = sprintf('%04s', $a->no_urut);
        }

        $no_aset = $request->jenis_aset_id . $request->merk_id . Carbon::now()->format('my') . $no_urut;

        Tmasets::create([
            'tgl'           => $request->tgl,
            'no_aset'       => $no_aset,
            'jenis_aset_id' => $request->jenis_aset_id,
            'serial'        => $request->serial,
            'merk_id'       => $request->merk_id,
            'tahun'         => $request->tahun,
            'kondisi'       => $request->kondisi,
            'jumlah'        => $request->jumlah,
            'status'        => $request->status,
            'created_by'    => Auth::user()->pegawai->n_pegawai,
            'created_at'    => Carbon::now(),
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
        return view('aset.masuk.form', compact(['id', 'tmjenis_asets', 'tmmerks']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tmaset = Tmasets::find($id);

        return response()->json(
            [
                'id'            => $tmaset->id,
                'tgl'           => $tmaset->tgl,
                'no_aset'       => $tmaset->no_aset,
                'jenis_aset_id' => $tmaset->jenis_aset_id,
                'serial'        => $tmaset->serial,
                'merk_id'       => $tmaset->merk_id,
                'tahun'         => $tmaset->tahun,
                'kondisi'       => $tmaset->kondisi,
                'jumlah'        => $tmaset->jumlah,
                'status'        => $tmaset->status,
            ]
        );
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
            'tgl'           => 'required',
            'no_aset'       => 'required',
            'jenis_aset_id' => 'required',
            'serial'        => 'required',
            'merk_id'       => 'required',
            'tahun'         => 'required',
            'kondisi'       => 'required',
            'jumlah'        => 'required',
            'status'        => 'required'
        ]);

        $tmaset = Tmasets::find($id);
        $tmaset->update(
            [
                'tgl'           => $request->tgl,
                'no_aset'       => $request->no_aset,
                'jenis_aset_id' => $request->jenis_aset_id,
                'serial'        => $request->serial,
                'merk_id'       => $request->merk_id,
                'tahun'         => $request->tahun,
                'kondisi'       => $request->kondisi,
                'jumlah'        => $request->jumlah,
                'status'        => $request->status,
                'updated_by'    => Auth::user()->pegawai->n_pegawai,
                'updated_at'    => Carbon::now(),
            ]
        );

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
        Tmasets::destroy($id);

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
        $tmaset = DB::table('tmasets')
            ->select('tmasets.id', 'tmasets.tgl', 'tmasets.no_aset', 'tmjenis_asets.n_jenis_aset', 'tmasets.serial', 'tmmerks.n_merk', 'tmasets.tahun', 'tmasets.kondisi', 'tmasets.jumlah', 'tmasets.status')
            ->join('tmjenis_asets', 'tmasets.jenis_aset_id', '=', 'tmjenis_asets.id')
            ->join('tmmerks', 'tmasets.merk_id', '=', 'tmmerks.id')
            ->get();
        return DataTables::of($tmaset)
            ->addColumn('action', function ($p) {
                return "
                   <a href='" . route('aset.masuk.show', $p->id) . "' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
