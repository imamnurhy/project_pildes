<?php

namespace App\Http\Controllers\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Storage;
use App\Models\Tmlelang;
use App\Models\Opd;

class LelangController extends Controller
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
        return view('lelang.lelang');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = 0;
        $opds = Opd::select('id', 'n_opd')->get();
        return view('lelang._lelang.form', compact('id', 'opds'));
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
            'n_lelang' => 'required|unique:tmlelangs,n_lelang',
            'ket' => 'required',
            'd_dari' => 'required|date',
            'd_sampai' => 'required|date',
            'nilai_sewa' => 'required',
            'jumlah_mobil' => 'required',
            'jumlah_motor' => 'required',
            'luas_lahan' => 'required',
            'alamat' => 'required',
            'c_status' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle Upload Foto
        if ($request->hasFile('foto')) {
            // GET Filename With The Extentions
            $filenameWithExt = $request->file('foto')->getClientOriginalName();
            // Get Just Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get Just Ext file
            $extensions = $request->file('foto')->getClientOriginalExtension();
            // Filename To Store
            $fileNameToStore = $filename.'_'.time().'.'.$extensions;
            // Upload Image To Local
            // $Path = $request->file('foto')->storeAs('lelang/parkir', $fileNameToStore);

            //Upload Image To Server <--114-->
            // Storage::disk('sftp')->put($fileNameToStore, fopen($request->file('foto'), 'r+'));
            // $extensions->storeAs('foto', $fileNameToStore, 'sftp', 'public');

            Storage::disk('sftp')->put('parkir/'.$fileNameToStore, fopen($request->file('foto'), 'r+'));

        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Lelang
        $post = Tmlelang::create([
            'n_lelang' => $request->n_lelang,
            'ket' => $request->ket,
            'd_dari' => $request->d_dari,
            'd_sampai' => $request->d_sampai,
            'jumlah_mobil' => $request->jumlah_mobil,
            'nilai_sewa' => $request->nilai_sewa,
            'jumlah_motor' => $request->jumlah_motor,
            'luas_lahan' => $request->luas_lahan,
            'alamat' => $request->alamat,
            'c_status' => $request->c_status,
            'foto' => $fileNameToStore,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Data lelang berhasil tersimpan.'
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
        $opds = Opd::select('id', 'n_opd')->get();
        return view('lelang._lelang.form', compact('id', 'opds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $opds = Opd::select('id', 'n_opd')->get();
        // $lelang = Tmlelang::findOrFail($id);
        // return view('lelang._lelang.edit', compact('opds', 'lelang'));
        return Tmlelang::findOrFail($id);
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
            'n_lelang' => 'required',
            'ket' => 'required',
            'd_dari' => 'required|date',
            'd_sampai' => 'required|date',
            'nilai_sewa' => 'required',
            'jumlah_mobil' => 'required',
            'jumlah_motor' => 'required',
            'luas_lahan' => 'required',
            'alamat' => 'required',
            'c_status' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            // GET Filename With The Extentions
            $filenameWithExt = $request->file('foto')->getClientOriginalName();
            // Get Just Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get Just Ext file
            $extensions = $request->file('foto')->getClientOriginalExtension();
            // Filename To Store
            $fileNameToStore = time().'.'.$extensions;
            // $fileNameToStore = $filename.$extensions;
            // Upload Image To Local
            // $Path = $request->file('foto')->storeAs('lelang/parkir', $fileNameToStore);

            //Upload Image To Server <--114-->
            // Storage::disk('sftp')->put($fileNameToStore, fopen($request->file('foto'), 'r+'));
            // $extensions->storeAs('foto', $fileNameToStore, 'sftp', 'public');


            // Storage::disk('sftp')->put('parkir/'.$fileNameToStore, fopen($request->file('foto'), 'r+'));

        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $post = [
            'n_lelang' => $request->n_lelang,
            'ket' => $request->ket,
            'd_dari' => $request->d_dari,
            'd_sampai' => $request->d_sampai,
            'jumlah_mobil' => $request->jumlah_mobil,
            'nilai_sewa' => $request->nilai_sewa,
            'jumlah_motor' => $request->jumlah_motor,
            'luas_lahan' => $request->luas_lahan,
            'alamat' => $request->alamat,
            'c_status' => $request->c_status,
            'foto' => $fileNameToStore,
        ];

        $tmlelang = Tmlelang::find($id);

        if($tmlelang->foto != ''){
            Storage::disk('sftp')->delete('parkir/'.$tmlelang->foto);
        }

        Storage::disk('sftp')->put('parkir/'.$fileNameToStore, fopen($request->file('foto'), 'r+'));
        $tmlelang->update($post);

        return response()->json([
            'success' => true,
            'message' => 'Data lelang berhasil diperbaharui.'
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
        Tmlelang::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data lelang berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmlelang = Tmlelang::select('id', 'opd_id', 'n_lelang', 'd_dari', 'd_sampai', 'c_status')->with(['opd:id,n_opd']);
        return Datatables::of($tmlelang)
            ->editColumn('d_dari', function($p){
                return \Carbon\Carbon::parse($p->d_dari)->format('d F Y');
            })
            ->editColumn('d_sampai', function($p){
                return \Carbon\Carbon::parse($p->d_sampai)->format('d F Y');
            })
            ->editColumn('c_status', function($p){
                if($p->c_status == 1){
                    $txt = "<span class='badge r-3 badge-primary'>Tampil</span>";
                }else{
                    $txt = "<span class='badge r-3'>Tidak Tampil</span>";
                }
                return $txt;
            })
            ->addColumn('syarats', function($p){
                return $p->trlelang_syarats()->count()." <a href='".route('lelangsyarat.index', $p->id)."' class='text-success pull-right' title='Edit Syarat'><i class='icon-notebook-list2 mr-1'></i></a>";
            })
            ->addColumn('action', function($p){
                return "
                    <a href='". route('lelang.show', $p->id) ."' title='Edit Lelang'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Lelang'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['syarats', 'c_status', 'action'])
            ->toJson();
    }
}
