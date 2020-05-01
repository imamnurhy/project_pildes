<?php

namespace App\Http\Controllers\Lelang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\Tmcontent;

class ContentController extends Controller
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
        return view('lelang.content');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = 0;
        return view('lelang._content.form', compact('id'));
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
            'n_content' => 'required|unique:tmcontents,n_content',
            'file' => 'required|mimes:doc,docx,pdf|max:5000',
            'c_status' => 'required'
        ]);

        $file = $request->file('file');
        $nameFile = rand() . '.' . $file->getClientOriginalExtension();
        // $file->storeAs('filedownload', $nameFile, 'sftp', 'public');
        Storage::disk('sftp')->put('filecontent/' . $nameFile, fopen($request->file('file'), 'r+'));

        Tmcontent::create([
            'n_content' => $request->n_content,
            'file' => $nameFile,
            'ket' => $request->ket,
            'c_status' => $request->c_status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data content berhasil tersimpan.'
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
        return view('lelang._content.form', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Tmcontent::findOrFail($id);
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
            'n_content' => 'required|unique:tmcontents,n_content,' . $id,
            'c_status' => 'required'
        ]);

        $input = $request->all();
        $tmcontent = Tmcontent::findOrFail($id);

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'mimes:doc,docx,pdf|max:5000',
            ]);
            $file = $request->file('file');
            $nameFile = rand() . '.' . $file->getClientOriginalExtension();
            // $file->storeAs('filedownload', $nameFile, 'sftp', 'public');
            Storage::disk('sftp')->put('filecontent/' . $nameFile, fopen($request->file('file'), 'r+'));
            $input['file'] = $nameFile;

            $lastFile = $tmcontent->file;
            Storage::disk('sftp')->delete('filecontent/' . $lastFile);
        }

        $tmcontent->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data content berhasil diperbaharui.'
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
        Tmcontent::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data content berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $tmcontent = Tmcontent::all();
        return Datatables::of($tmcontent)
            ->editColumn('c_status', function ($p) {
                if ($p->c_status == 1) {
                    $txt = "<span class='badge r-3 badge-primary'>Tampil</span>";
                } else {
                    $txt = "<span class='badge r-3'>Tidak Tampil</span>";
                }
                return $txt;
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='" . route('content.show', $p->id) . "' title='Edit Konten'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Konten'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['c_status', 'action'])
            ->toJson();
    }
}
