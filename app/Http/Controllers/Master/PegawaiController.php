<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Pegawai;
use App\Models\Unitkerja;
use App\Models\Opd;
use App\Models\User;
use App\Models\Golongan;
use App\Models\Eselon;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Tmopd;

class PegawaiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $provinsis = Provinsi::select('id', 'kode', 'n_provinsi')->get();
        $pegawai = Pegawai::find(Auth::user()->id);
        $auth_pegawai_id = ($pegawai) ? $pegawai->id : 0;
        return view('master.pegawai', compact('provinsis', 'auth_pegawai_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik'          => 'required|min:16|max:16|unique:pegawais,nik',
            'n_pegawai'    => 'required',
            'telp'         => 'required|string|min:10|max:14|unique:pegawais,telp',
            'alamat'       => 'required',
            't_lahir'      => 'required',
            'd_lahir'      => 'required',
            'jk'           => 'required',
            'rt'           => 'required',
            'rw'           => 'required',
            'kelurahan_id' => 'required',
        ]);

        $input = $request->all();
        Pegawai::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data pegawai berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        $kecamatan_id = Kelurahan::select('kecamatan_id')->whereid($pegawai->kelurahan_id)->first()->kecamatan_id;
        $kabupaten_id = Kecamatan::select('kabupaten_id')->whereid($kecamatan_id)->first()->kabupaten_id;
        $provinsi_id = Kabupaten::select('provinsi_id')->whereid($kabupaten_id)->first()->provinsi_id;

        $kelurahans = $this->getKelurahan($kecamatan_id);
        $kecamatans = $this->getKecamatan($kabupaten_id);
        $kabupatens = $this->getKabupaten($provinsi_id);

        return response()->json([
            'pegawai' => $pegawai,
            'provinsi_id' => $provinsi_id,
            'kabupaten_id' => $kabupaten_id,
            'kecamatan_id' => $kecamatan_id,
            'kelurahan_id' => $pegawai->kelurahan_id,
            'kabupatens' => $kabupatens,
            'kecamatans' => $kecamatans,
            'kelurahans' => $kelurahans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik'          => 'required|min:16|max:16|unique:pegawais,nik' . $id,
            'n_pegawai'    => 'required',
            'telp'         => 'required|string|min:10|max:14|unique:pegawais,telp' . $id,
            'alamat'       => 'required',
            't_lahir'      => 'required',
            'd_lahir'      => 'required',
            'jk'           => 'required',
            'rt'           => 'required',
            'rw'           => 'required',
            'kelurahan_id' => 'required',
        ]);

        $input = $request->all();
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data pegawai berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        User::destroy($pegawai->user_id);
        Pegawai::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data pegawai berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $pegawai = Pegawai::get();
        return Datatables::of($pegawai)
            ->editColumn('user_id', function ($p) {
                if ($p->user_id == "") {
                    return "Tidak <a href='" . route('user.add_user', $p->id) . "' class='float-right text-success' title='Tambah sebagai pengguna aplikasi'><i class='icon-user-plus'></i></a>";
                } else {
                    return "Ya <a href='" . route('user.edit', $p->user_id) . "' class='float-right' title='Edit akun user'><i class='icon-user'></i></a>";
                }
            })
            ->addColumn('action', function ($p) {
                return
                    "<a  href='#' onclick='edit(" . $p->id . ")' title='Edit Pegawai'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Pegawai' id='del_" . $p->id . "'><i class='icon-remove'></i></a>";
            })
            ->editColumn('rt_rw', function ($p) {
                return $p->rt . ' / ' . $p->rw;
            })
            ->rawColumns(['user_id', 'action'])
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
}
