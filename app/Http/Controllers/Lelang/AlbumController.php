<?php

namespace App\Http\Controllers\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Tmalbum;

class AlbumController extends Controller
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
        return view('lelang.album');
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
            'n_album' => 'required|unique:tmalbums,n_album',
            'ket' => 'required',
            'c_status' => 'required'
        ]);

        $input = $request->all();
        Tmalbum::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data album berhasil tersimpan.'
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
        return Tmalbum::find($id);
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
            'n_album' => 'required|unique:tmalbums,n_album,'.$id,
            'ket' => 'required',
            'c_status' => 'required'
        ]);

        $input = $request->all();
        $tmalbum = Tmalbum::findOrFail($id);
        $tmalbum->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data album berhasil diperbaharui.'
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
        Tmalbum::destroy($id);
        Storage::disk('sftp')->delete('public/album/'.$id);

        return response()->json([
            'success' => true,
            'message' => 'Data album berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmalbum = Tmalbum::all();
        return Datatables::of($tmalbum)
            ->editColumn('c_status', function($p){
                if($p->c_status == 1){
                    return "<span class='badge r-3 badge-primary'>Tampil</span>";
                }else{
                    return "<span class='badge r-3'>Tidak Tampil</span>";
                }
                return $txt;
            })
            ->addColumn('tmalbumfoto', function($p){
                return $p->tmalbumfotos()->count()." <a href='".route('albumfoto.index', $p->id)."' class='text-success pull-right' title='List Foot'><i class='icon-arrow-right mr-1'></i></a>";
            })
            ->addColumn('action', function($p){
                return "
                    <a onclick='edit(".$p->id.")' data-fancybox data-src='#formAdd' data-modal='true' href='javascript:;' title='Edit Album'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Album'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['c_status', 'tmalbumfoto', 'action'])
            ->toJson();
    }
}
