<?php

namespace App\Http\Controllers\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Tmlelang;
use App\Models\Tmsyarat;
use App\Models\Trlelang_syarat;

class LelangsyaratController extends Controller
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
        $tmlelang = Tmlelang::findOrFail($id);
        $tmsyarats = Tmsyarat::get();
        return view('lelang.lelangsyarat', compact('id', 'tmlelang', 'tmsyarats'));
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
            'tmlelang_id' => 'required',
            'tmsyarat_id' => 'required',
            'c_status' => 'required',
            'no_urut' => 'required'
        ]);

        $tmlelang_id = $request->input('tmlelang_id');
        $tmsyarat_id = $request->input('tmsyarat_id');
        $cek = Trlelang_syarat::where('tmlelang_id', $tmlelang_id)->where('tmsyarat_id', $tmsyarat_id)->count();
        if($cek > 0)
        {
            $err = [
                'syarat' => ["The syarat lelang has already been taken."]
            ];
            return response()->json([
                'message' => "The given data was invalid.",
                'errors'  => $err
            ], 422);
        }
        else
        {
            $input = $request->all();
            Trlelang_syarat::create($input);

            return response()->json([
                'success' => true,
                'message' => 'Data syarat lelang berhasil tersimpan.'
            ]);
        }
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
        return Trlelang_syarat::findOrFail($id);
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
            'tmlelang_id' => 'required',
            'tmsyarat_id' => 'required',
            'c_status' => 'required',
            'no_urut' => 'required'
        ]);

        $tmlelang_id = $request->input('tmlelang_id');
        $tmsyarat_id = $request->input('tmsyarat_id');
        $cek = Trlelang_syarat::where('tmlelang_id', $tmlelang_id)->where('tmsyarat_id', $tmsyarat_id)->where('id', '!=', $id)->count();
        if($cek > 0)
        {
            $err = [
                'syarat' => ["The syarat lelang has already been taken."]
            ];
            return response()->json([
                'message' => "The given data was invalid.",
                'errors'  => $err
            ], 422);
        }
        else
        {
            $input = $request->all();
            $trlelang_syarat = Trlelang_syarat::findOrFail($id);
            $trlelang_syarat->update($input);
    
            return response()->json([
                'success' => true,
                'message' => 'Data syarat lelang berhasil diperbaharui.'
            ]);
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
        Trlelang_syarat::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data syarat lelang berhasil dihapus.'
        ]);
    }

    public function api($id)
    {
        $tmlelang = Trlelang_syarat::where('tmlelang_id', $id)->with(['tmsyarat:id,n_syarat'])->get();
        return Datatables::of($tmlelang)
            ->editColumn('c_status', function($p){
                if($p->c_status == 1){
                    return "Wajib";
                }else{
                    return "Tentatif";
                }
            })
            ->addColumn('action', function($p){
                return "
                    <a href='#' onclick='edit(".$p->id.")' title='Edit Lelang'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Lelang'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->removeColumn('tmsyarat.id')
            ->toJson();
    }
}
