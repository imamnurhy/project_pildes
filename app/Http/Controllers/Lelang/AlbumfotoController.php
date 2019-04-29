<?php

namespace App\Http\Controllers\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\Tmalbum;
use App\Models\Tmalbumfoto;

class AlbumfotoController extends Controller
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
    public function index($id)
    {
        $tmalbum = Tmalbum::findOrFail($id);
        return view('lelang.albumfoto', compact('id', 'tmalbum'));
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
        $request->validate([
            'tmalbum_id' => 'required',
            'no_urut' => 'required',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'c_status' => 'required',
            'ket' => 'required',
        ]);

        $tmalbum_id = $request->tmalbum_id;
        $img = $request->file('img');
        $nameImg = rand().'.'.$img->getClientOriginalExtension();
        $path = 'album/'.$tmalbum_id;
        if(!Storage::disk('sftp')->exists($path)){
            Storage::disk('sftp')->makeDirectory($path);
        }
        $img->storeAs($path.'/', $nameImg, 'sftp', 'public');

        $input = $request->all();
        $input['img'] = $tmalbum_id.'/'.$nameImg;
        Tmalbumfoto::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data foto berhasil tersimpan.'
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
        return Tmalbumfoto::findOrFail($id);
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
            'tmalbum_id' => 'required',
            'no_urut' => 'required',
            'c_status' => 'required',
            'ket' => 'required',
        ]);

        $input = $request->all();
        $tmalbumfoto = Tmalbumfoto::findOrFail($id);

        if($request->hasFile('img'))
        {
            $tmalbum_id = $request->tmalbum_id;
            $request->validate([
                'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $img = $request->file('img');
            $nameImg = rand().'.'.$img->getClientOriginalExtension();
            $path = 'public/album/'.$tmalbum_id;
            if(!Storage::disk('sftp')->exists($path)){
                Storage::disk('sftp')->makeDirectory($path);
            }
            $img->storeAs($path, $nameImg, 'sftp', 'public');
            $input['img'] = $tmalbum_id.'/'.$nameImg;

            $lastFile = $tmalbumfoto->img;
            Storage::disk('sftp')->delete('public/album/'.$lastFile);
        }
        $tmalbumfoto->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data foto berhasil diperbaharui.'
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
        $tmalbumfoto = Tmalbumfoto::findOrFail($id);
        $lastFile = $tmalbumfoto->img;
        Storage::disk('sftp')->delete('public/album/'.$lastFile);

        Tmalbumfoto::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data foto berhasil dihapus.'
        ]);
    }

    public function api($id)
    {
        $tmalbumfoto = Tmalbumfoto::where('tmalbum_id', $id);
        return Datatables::of($tmalbumfoto)
            ->editColumn('img', function($p){
                return "<img src='".env("SFTP_SRC").'album/'.$p->img."' alt='foto' width='120px'/>";
            })
            ->editColumn('c_status', function($p){
                if($p->c_status == 1){
                    return "<span class='badge r-3 badge-primary'>Tampil</span>";
                }else{
                    return "<span class='badge r-3'>Tidak Tampil</span>";
                }
                return $txt;
            })
            ->addColumn('action', function($p){
                return "
                    <a onclick='edit(".$p->id.")' data-fancybox data-src='#formAdd' data-modal='true' href='javascript:;' title='Edit Foto'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Foto'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['img', 'c_status', 'action'])
            ->toJson();
    }
}
