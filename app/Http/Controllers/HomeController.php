<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Registrasi;
use App\Models\Tm_pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $layanan = Layanan::all();
        $ttl_layanan = $layanan->count();
        $ttl_pelanggan = Pelanggan::count();
        $ttl_registrasi = Registrasi::where('status', 0)->count();

        return view('home', compact(
            'layanan',
            'ttl_layanan',
            'ttl_pelanggan',
            'ttl_registrasi'
        ));
    }

    public function api(Request $request)
    {
        $pelanggan = Pelanggan::with('layanan', 'tmPembayaran');

        if ($request->tgl_pembayaran != null) {
            $pelanggan->whereDay('tgl_daftar', Carbon::parse($request->tgl_pembayaran)->format('d'));
            $pelanggan->whereMonth('tgl_daftar', '!=', Carbon::parse($request->tgl_pembayaran)->format('m'));
        }

        if ($request->layanan_id != 99) {
            $pelanggan->where('layanan_id', $request->layanan_id);
        }

        return DataTables::of($pelanggan)
            ->editColumn('status', function ($p) use ($request) {
                if ($p->tmPembayaran->count() > 0) {
                    foreach ($p->tmPembayaran as $tmPembayaran) {
                        if (Carbon::parse($tmPembayaran->tgl_bayar)->format('Y') == Carbon::parse($request->tgl_pembayaran)->format('Y') && Carbon::parse($tmPembayaran->tgl_bayar)->format('m') == Carbon::parse($request->tgl_pembayaran)->format('m')) {
                            if ($tmPembayaran->status == 1) {
                                return 'Lunas';
                            } else {
                                return 'Belum lunas';
                            }
                        } else {
                            return 'Belum melakukan pembayaran pada bulan ini';
                        }
                    }
                } else {
                    return 'Belum melakukan pembayaran sama sekali';
                }
            })
            ->editColumn('jml_bayar', function ($p) use ($request) {
                if ($p->tmPembayaran->count() > 0) {
                    foreach ($p->tmPembayaran as $tmPembayaran) {
                        if (Carbon::parse($tmPembayaran->tgl_bayar)->format('Y') == Carbon::parse($request->tgl_pembayaran)->format('Y') && Carbon::parse($tmPembayaran->tgl_bayar)->format('m') == Carbon::parse($request->tgl_pembayaran)->format('m')) {
                            return $tmPembayaran->jml_bayar;
                        } else {
                            return 0;
                        }
                    }
                } else {
                    return '-';
                }
            })
            ->editColumn('tagihan', function ($p) use ($request) {
                if ($p->tmPembayaran->count() > 0) {
                    foreach ($p->tmPembayaran as $tmPembayaran) {
                        if (Carbon::parse($tmPembayaran->tgl_bayar)->format('Y') == Carbon::parse($request->tgl_pembayaran)->format('Y') && Carbon::parse($tmPembayaran->tgl_bayar)->format('m') == Carbon::parse($request->tgl_pembayaran)->format('m')) {
                            return $p->layanan->harga - $tmPembayaran->jml_bayar;
                        } else {
                            return 0;
                        }
                    }
                } else {
                    return '-';
                }
            })

            ->addColumn('action', function ($p) {
                if ($p->tmPembayaran->count() > 0) {
                    foreach ($p->tmPembayaran as $tmPembayaran) {
                        if ($tmPembayaran->status == 1) {
                            return "<a title='Pembayaran succes'><i class='icon-check-circle-o mr-1'></i></a>";
                        } else {
                            return "<a onclick='paid(" . $p->id . ")' class='text-blue' title='Bayar'><i class='icon-check-circle-o mr-1'></i></a>";
                        }
                    }
                } else {
                    return "<a onclick='paid(" . $p->id . ")' class='text-blue' title='Bayar'><i class='icon-check-circle-o mr-1'></i></a>";
                }
            })
            ->rawColumns(['status', 'jml_bayar', 'tagihan', 'action'])
            ->toJson();
    }

    public function paid(Request $request)
    {
        $pelanggan = Pelanggan::where('id', $request->pelanggan_id)->with('layanan')->first();

        Tm_pembayaran::create([
            'pelanggan_id' => $request->pelanggan_id,
            'tgl_bayar' => $request->tgl_pembayaran,
            'jml_bayar' => $pelanggan->layanan->harga,
            'status' => 1,
        ]);

        return response()->json(['message' => 'Pembayaran berhasil tersimpan']);
    }
}
