<?php

namespace App\Http\Controllers\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\Tmsyarat;

class SyaratController extends Controller
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
        return view('lelang.syarat');
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
            'n_syarat' => 'required|unique:tmsyarats,n_syarat',
            'file' => 'mimes:doc,docx,pdf|max:5000',
            'ket' => 'required'
        ]);

        // Handle Upload Foto
        if ($request->hasFile('file')) {
            // GET Filename With The Extentions
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            // Get Just Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get Just Ext file
            $extensions = $request->file('file')->getClientOriginalExtension();
            // Filename To Store
            $fileNameToStore = $filename . '_' . time() . '.' . $extensions;

            Storage::disk('sftp')->put('filedownload/' . $fileNameToStore, fopen($request->file('foto'), 'r+'));
        } else {
            $fileNameToStore = '';
        }

        Tmsyarat::create([
            'n_syarat' => $request->n_syarat,
            'file' => $fileNameToStore,
            'ket' => $request->ket
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data syarat berhasil tersimpan.'
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
        return Tmsyarat::find($id);
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
            'n_syarat' => 'required|unique:tmsyarats,n_syarat,' . $id,
            'ket' => 'required'
        ]);


        $tmsyarat = Tmsyarat::findOrFail($id);

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'mimes:doc,docx,pdf|max:5000',
            ]);
            $file = $request->file('file');
            $nameFile = rand() . '.' . $file->getClientOriginalExtension();
            // $file->storeAs('filedownload', $nameFile, 'sftp', 'public');
            Storage::disk('sftp')->put('filedownload/' . $nameFile, fopen($request->file('file'), 'r+'));
            $input['file'] = $nameFile;

            // $lastFile = $tmsyarat->file;
            // Storage::disk('sftp')->delete('filedownload/' . $lastFile);
        } else {
            $nameFile = '';
        }

        $tmsyarat->update([
            'n_syarat' => $request->n_syarat,
            'file' => $nameFile,
            'ket' => $request->ket
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data syarat berhasil diperbaharui.'
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
        $tmsyarat = Tmsyarat::findOrFail($id);
        $lastFile = $tmsyarat->file;
        Storage::disk('sftp')->delete('filedownload/' . $lastFile);

        Tmsyarat::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data syarat berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmsyarat = Tmsyarat::all();
        return Datatables::of($tmsyarat)
            ->addColumn('action', function ($p) {
                return "
                    <a onclick='edit(" . $p->id . ")' data-fancybox data-src='#formAdd' data-modal='true' href='javascript:;' title='Edit Syarat'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Syarat'><i class='icon-remove'></i></a>";
            })
            ->editColumn('file', function ($p) {
                if ($p->file != '') {
                    return "<a href='" . env("SFTP_SRC") . 'filedownload/' . $p->file . "' target='_blank'><i class='icon icon-document-download2'></i> Unduh</a>";
                } else {
                    return "<a target='_blank'><i class='icon icon-document-download2'></i>NoFile</a>";
                }
            })
            ->rawColumns(['action', 'file'])
            ->toJson();
    }
}
