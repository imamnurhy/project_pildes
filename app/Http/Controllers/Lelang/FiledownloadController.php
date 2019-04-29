<?php

namespace App\Http\Controllers\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\Tmfiledownload;

class FiledownloadController extends Controller
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
        return view('lelang.filedownload');
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
            'n_filedownload' => 'required|unique:tmfiledownloads,n_filedownload',
            'file' => 'required|mimes:doc,docx,pdf|max:5000',
            'c_status' => 'required',
            'ket' => 'required',
        ]);

        $file = $request->file('file');
        $nameFile = rand().'.'.$file->getClientOriginalExtension();
        $file->storeAs('filedownload', $nameFile, 'sftp', 'public');

        Tmfiledownload::create([
            'n_filedownload' => $request->n_filedownload,
            'file' => $nameFile,
            'c_status' => $request->c_status,
            'ket' => $request->ket
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data filedownload berhasil tersimpan.'
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
        return Tmfiledownload::findOrFail($id);
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
            'n_filedownload' => 'required|unique:tmfiledownloads,n_filedownload,'.$id,
            'c_status' => 'required',
            'ket' => 'required',
        ]);

        $input = $request->all();
        $tmfiledownload = Tmfiledownload::findOrFail($id);

        if($request->hasFile('file'))
        {
            $request->validate([
                'file' => 'required|mimes:doc,docx,pdf|max:5000',
            ]);
            $file = $request->file('file');
            $nameFile = rand().'.'.$file->getClientOriginalExtension();
            $file->storeAs('filedownload', $nameFile, 'sftp', 'public');
            $input['file'] = $nameFile;

            $lastFile = $tmfiledownload->file;
            Storage::disk('sftp')->delete('filedownload/'.$lastFile);
        }
        $tmfiledownload->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data filedownload berhasil diperbaharui.'
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
        $tmfiledownload = Tmfiledownload::findOrFail($id);
        $lastFile = $tmfiledownload->file;
        Storage::disk('sftp')->delete('filedownload/'.$lastFile);

        Tmfiledownload::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data filedownload berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmfiledownload = Tmfiledownload::all();
        return Datatables::of($tmfiledownload)
            ->editColumn('file', function($p){
                return "<a href='".env("SFTP_SRC").'filedownload/'.$p->file."' target='_blank'><i class='icon icon-document-download2'></i> Unduh</a>";
            })
            ->editColumn('c_status', function($p){
                if($p->c_status == 1){
                    $txt = "<span class='badge r-3 badge-primary'>Tampil</span>";
                }else{
                    $txt = "<span class='badge r-3'>Tidak Tampil</span>";
                }
                return $txt;
            })
            ->addColumn('action', function($p){
                return "
                    <a onclick='edit(".$p->id.")' data-fancybox data-src='#formAdd' data-modal='true' href='javascript:;' title='Edit File Download'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus File Download'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['file', 'c_status', 'action'])
            ->toJson();
    }
}
