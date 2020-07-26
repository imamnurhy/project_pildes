<?php

namespace App\Http\Controllers;

use App\Models\Tmpermohonan;
use Illuminate\Http\Request;
use PDO;
use Yajra\DataTables\DataTables;

class PermohonanController extends Controller
{
    public function index()
    {
        $tmpermohonan = Tmpermohonan::all();

        $totalPermohonan = Tmpermohonan::count();
        $verifikasiProsess = Tmpermohonan::where('status', 0)->count();
        $verifikasiSuccess = Tmpermohonan::where('status', 1)->count();
        $verifikasiGagal = Tmpermohonan::where('status', 2)->count();


        return view('permohonan.index', compact([
            'tmpermohonan',
            'totalPermohonan',
            'verifikasiProsess',
            'verifikasiSuccess',
            'verifikasiGagal'
        ]));
    }

    public function edit($id)
    {
        $tmpermohonan = Tmpermohonan::with('tmopd')->find($id);
        return view('permohonan.edit', compact('tmpermohonan'));
    }

    public function update(Request $request, $id)
    {
        $tmpermohonan = Tmpermohonan::find($id);

        $alasan_tolak = '';

        if ($request->status == 2) {
            $alasan_tolak = $request->alasan_tolak;
        }

        $tmpermohonan->update([
            'n_pegawai'    => $request->n_pegawai,
            'status'       => $request->status,
            'alasan_tolak' => $alasan_tolak
        ]);
    }

    public function api()
    {
        $tmpermohonan = Tmpermohonan::with('tmopd')->get();
        return DataTables::of($tmpermohonan)
            ->addColumn('action', function ($p) {
                $btnEdit = "<a href='" . route('permohonan.edit', $p->id) . "' title='Edit Merek'><i class='icon-pencil mr-1'></i></a>";
                $btnRemove = "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Merek'><i class='icon-remove'></i></a>";
                return $btnEdit . $btnRemove;
            })
            ->editColumn('jenis_permohonan', function ($p) {
                $jenis_permohonan = '';
                if ($p->jenis_permohonan == 1) {
                    $jenis_permohonan = 'Pengajuan Pemasangan Internet';
                } else if ($p->jenis_permohonan == 2) {
                    $jenis_permohonan = 'Penambahan Pemasangan Internet';
                }
                return $jenis_permohonan;
            })
            ->addColumn('detail', function ($p) {
                return "<a href='#' id='btn_detail_" . $p->id . "' onclick='showPermohonanDetail(" . $p->id . ")'title='Show Detail'><br/><i class='icon-eye mr-1'>Detail</i></a>";
            })
            ->editColumn('status', function ($p) {
                $status = '';
                if ($p->status == 0) {
                    $status = 'Proses verifikasi berkas';
                } else if ($p->status == 1) {
                    $status = 'Di setujui';
                } else if ($p->status == 2) {
                    $status = 'Di tolak';
                }
                return $status;
            })
            ->rawColumns(['action', 'detail'])
            ->toJson();
    }

    public function detail($id)
    {
        return Tmpermohonan::with('tmopd')->where('id', $id)->first();
    }

    public function destroy($id)
    {
        Tmpermohonan::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
