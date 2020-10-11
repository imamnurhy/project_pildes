<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class RegistrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('registrasi.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Registrasi::find($id);
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
            'tgl_pemasangan' => 'required',
            'status'         => 'required',
        ]);

        $registrasi = Registrasi::find($id);

        $registrasi->update([
            'tgl_pemasangan' => $request->tgl_pemasangan,
            'pegawai_id'     => Auth::user()->pegawai->id,
            'status'         => $request->status,
        ]);

        return response()->json(['message' => 'Data berhasil diperbaharui.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Registrasi::destroy($id);

        return response()->json(['message' => 'Data berhasil hapus.']);
    }

    public function api(Request $request)
    {

        $registrasi = Registrasi::with('layanan');

        if ($request->tgl_daftar_filter != '') {
            $registrasi->whereDay('tgl_daftar', Carbon::parse($request->tgl_daftar_filter)->format('d'));
        }

        if ($request->status_filter != 99) {
            $registrasi->where('status', $request->status_filter);
        }


        return DataTables::of($registrasi)
            ->editColumn('tgl_daftar', function ($p) {
                return Carbon::parse($p->tgl_daftar)->format('Y-m-d');
            })
            ->addColumn('action', function ($p) {
                $btnEdit = "<a onclick='edit(" . $p->id . ")' class='text-blue' title='Edit Layanan'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus layanan'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
