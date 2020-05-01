<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Hash;

use App\Models\Tmregistrasi;
use App\Models\Tmpelamar;


class PelamarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pelamar.tabel');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $registrasi = Tmregistrasi::findOrFail($id);
        $pelamars = Tmpelamar::select('id', 'tmlelang_id', 'tmregistrasi_id')->where('tmregistrasi_id', $id)->with(['tmlelang', 'tmregistrasi'])->get();
        return view('pelamar.edit', compact('pelamars', 'registrasi'));
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
        switch ($request->type) {

            case 1:
                $request->validate([
                    'password' => 'required|string|min:6|confirmed'
                ]);

                $password = Hash::make($request->password);
                $user = Tmregistrasi::findOrFail($id);
                $user->password = $password;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Data user berhasil diperbaharui. Password user ' . $request->password
                ]);
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tmpelamar::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data Pelamar berhasil dihapus.'
        ]);
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Tmregistrasi::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data Registrasi Pelamar berhasil dihapus.'
        ]);
    }

    public function api(Request $request)
    {
        $tmregistrasi = Tmregistrasi::all();
        return Datatables::of($tmregistrasi)
            ->editColumn('created_at', function ($tmregistrasi) {
                return \Carbon\Carbon::parse($tmregistrasi->created_at)->format('d F Y H:i:s');
            })
            ->editColumn('t_lahir_pl', function ($tmregistrasi) {
                return $tmregistrasi->t_lahir_pl . ' ' .  \Carbon\Carbon::parse($tmregistrasi->d_lahir_pl)->format('d F Y');
            })
            ->addColumn('action', function ($tmregistrasi) {
                return "
                    <a href='" . route('pelamar.edit', $tmregistrasi->id) . "' title='Edit Lahan'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $tmregistrasi->id . ")' class='text-danger' title='Hapus Pelamar'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function exportToExcel($d_dari, $d_sampai)
    {
        $tmregistrasis = Tmregistrasi::whereBetween('created_at', [$d_dari . ' 00:00:00', $d_sampai . ' 23:59:59'])->get();
        return view('report.registrasi.export', compact('tmregistrasis', 'd_dari', 'd_sampai'));
    }
}
