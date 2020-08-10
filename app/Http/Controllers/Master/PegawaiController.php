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
        $tmopds = Tmopd::select('id', 'n_lokasi')->get();
        $provinsis = Provinsi::select('id', 'kode', 'n_provinsi')->get();
        $pegawai = Pegawai::find(Auth::user()->id);
        $auth_pegawai_id = ($pegawai) ? $pegawai->id : 0;
        return view('master.pegawai', compact('provinsis', 'tmopds', 'auth_pegawai_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|min:16|max:16|unique:pegawais,nik',
            'n_pegawai' => 'required',
            't_lahir' => 'required',
            'd_lahir' => 'required',
            'jk' => 'required',
            'pekerjaan' => 'required',
            'kelurahan_id' => 'required',
            'alamat' => 'required',
            'nip' => 'required|string|min:18|max:18|unique:pegawais,nip',
            'telp' => 'required|string|min:10|max:14|unique:pegawais,telp',
            'tmopd_id' => 'required'
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
            'tmopd_id' => $pegawai->tmopd_id
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|string|min:18|max:18|unique:pegawais,nip,' . $id,
            'n_pegawai' => 'required',
            'telp' => 'required|string|min:10|max:14|unique:pegawais,telp,' . $id,
            'opd_id' => 'required',
            'nik' => 'required|string|min:16|max:16|unique:pegawais,nik,' . $id,
            't_lahir' => 'required',
            'd_lahir' => 'required',
            'jk' => 'required',
            'pekerjaan' => 'required',
            'kelurahan_id' => 'required',
            'alamat' => 'required',
            'instansi' => 'required'
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
        $lastFoto = $pegawai->foto;
        if ($lastFoto != '') {
            Storage::disk('sftp')->delete('foto/' . $lastFoto);
        }

        User::destroy($pegawai->user_id);
        Pegawai::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data pegawai berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $pegawai = Pegawai::with(['tmopds:id,n_lokasi'])->get();
        return Datatables::of($pegawai)
            ->editColumn('user_id', function ($p) {
                if ($p->user_id == "") {
                    return "Tidak <a href='" . route('user.add_user', $p->id) . "' class='float-right text-success' title='Tambah sebagai pengguna aplikasi'><i class='icon-user-plus'></i></a>";
                } else {
                    return "Ya <a href='" . route('user.edit', $p->user_id) . "' class='float-right' title='Edit akun user'><i class='icon-user'></i></a>";
                }
            })
            ->editColumn('foto', function ($p) {
                if ($p->foto == "") {
                    $img = "Tidak";
                } else {
                    $img = "<img src='" . 'http://103.219.112.114/asetgrup_storage/public/foto/' . $p->foto . "' alt='img' align='center' width='50%'/>";
                }
                return $img . "<br/><a onclick='editFoto(" . $p->id . ")' href='javascript:;' data-fancybox data-src='#formUpload' data-modal='true' title='Upload foto pegawai' class='btn btn-xs'>Unggah Foto <i class='icon-upload'></i></a>";
            })
            ->addColumn('action', function ($p) {
                return
                    "<a onclick='edit(" . $p->id . ")' data-fancybox data-src='#formAdd' data-modal='true' href='javascript:;' title='Edit Pegawai'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Pegawai' id='del_" . $p->id . "'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['foto', 'user_id', 'action'])
            ->toJson();
    }

    public function getUnitkerja($opd_id)
    {
        return Opd::whereid($opd_id)->with('unitkerjas')->first()->unitkerjas;
    }

    public function getNik(Request $request)
    {
        $v_identitas = $request->nik;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://192.168.200.20/cek_nik.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\"username\":\"KOMINFO\",\n\t\"password\":\"Abcde!@#$%\",\n\t\"nik\":\"$v_identitas\"\n}"
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $err = false;

        if ($err) {
            return response()->json([
                'message' => "Terdapat masalah saat melakukan get KTP. Silahkan laporkan kesalahan ini pada Administrator."
            ], 422);
        } else {
            $obj = json_decode($response);
            if ($obj == "") {
                return response()->json([
                    'message' => "Terdapat masalah saat melakukan get KTP ke Server Dukcapil. Silahkan tunggu beberapa saat sampai koneksi ke Server Dukcapil kembali normal."
                ], 422);
            } else {
                if (isset($obj->content[0]->RESPONSE_CODE)) {
                    return response()->json([
                        'message' => "Data KTP tidak ditemukan."
                    ], 422);
                } else {

                    //--- CEK ALAMAT
                    $provinsi_id = '';
                    $kabupaten_id = '';
                    $kecamatan_id = '';
                    $kelurahan_id = '';
                    $kabupatens = '';
                    $kecamatans = '';
                    $kelurahans = '';
                    $msg_err = '';

                    $no_prop = $obj->content[0]->NO_PROP;
                    $no_kab = $no_prop . '.' . sprintf("%02s", $obj->content[0]->NO_KAB);
                    $no_kec = $no_kab . '.' . sprintf("%02s", $obj->content[0]->NO_KEC);
                    $no_kel = $no_kec . '.' . sprintf("%04s", $obj->content[0]->NO_KEL);

                    $provinsi = Provinsi::select('id', 'n_provinsi')->wherekode($no_prop)->first();
                    if (!$provinsi) {
                        $msg_err = "Kode provinsi " . $no_prop . " " . $obj->content[0]->PROP_NAME;
                    } else {
                        $provinsi_id = $provinsi->id;
                        $kabupatens = $this->getKabupaten($provinsi_id);

                        $kabupaten = Kabupaten::select('id')->wherekode($no_kab)->first();
                        if (!$kabupaten) {
                            $msg_err = "Kode kabupaten " . $no_kab . " " . $obj->content[0]->KAB_NAME;
                        } else {
                            $kabupaten_id = $kabupaten->id;
                            $kecamatans = $this->getKecamatan($kabupaten_id);

                            $kecamatan = Kecamatan::select('id')->wherekode($no_kec)->first();
                            if (!$kecamatan) {
                                $msg_err = "Kode kecamatan " . $no_kab . " " . $obj->content[0]->KEC_NAME;
                            } else {
                                $kecamatan_id = $kecamatan->id;
                                $kelurahans = $this->getKelurahan($kecamatan_id);

                                $kelurahan = Kelurahan::select('id')->wherekode($no_kel)->first();
                                if (!$kelurahan) {
                                    $msg_err = "Kode kecamatan " . $no_kab . " " . $obj->content[0]->KEL_NAME;
                                } else {
                                    $kelurahan_id = $kelurahan->id;
                                }
                            }
                        }
                    }

                    //--- RESPON NIK
                    return response()->json([
                        'status' => 1,
                        'NAMA_LGKP' => $obj->content[0]->NAMA_LGKP,
                        'ALAMAT' => $obj->content[0]->ALAMAT,
                        'AGAMA' => $obj->content[0]->AGAMA,
                        'NO_RW' => $obj->content[0]->NO_RW,
                        'JENIS_PKRJN' => $obj->content[0]->JENIS_PKRJN,
                        'NO_RT' => $obj->content[0]->NO_RT,
                        'TMPT_LHR' => $obj->content[0]->TMPT_LHR,
                        'PDDK_AKH' => $obj->content[0]->PDDK_AKH,
                        'JENIS_KLMIN' => $obj->content[0]->JENIS_KLMIN,
                        'TGL_LHR' => $obj->content[0]->TGL_LHR,

                        'provinsi_id' => $provinsi_id,
                        'kabupaten_id' => $kabupaten_id,
                        'kecamatan_id' => $kecamatan_id,
                        'kelurahan_id' => $kelurahan_id,
                        'kabupatens' => $kabupatens,
                        'kecamatans' => $kecamatans,
                        'kelurahans' => $kelurahans,
                        'msg_err' => $msg_err
                    ]);
                }
            }
        }
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

    //--- Foto
    public function updateFoto(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // dd(config());

        $pegawai = Pegawai::findOrFail($id);
        $lastFoto = $pegawai->foto;
        $foto = $request->file('foto');
        $nameFoto = $pegawai->nip . '_' . rand() . '.' . $foto->getClientOriginalExtension();
        $foto->storeAs('foto', $nameFoto, 'sftp', 'public');
        $pegawai->foto = $nameFoto;
        $pegawai->save();

        if ($lastFoto != '') {
            Storage::disk('sftp')->delete('foto/' . $lastFoto);
        }

        return response()->json([
            'success'   => true,
            'message' => $nameFoto
        ]);
    }
}
