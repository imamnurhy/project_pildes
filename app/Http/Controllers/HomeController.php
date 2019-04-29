<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tmlelang;
use App\Models\Tmpelamar;

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
        return view('home');
    }

    public function grafikLelang()
    {
        $data = [];
        $pelamarTotal = 0;
        $prosesTotal = 0;
        $tolakTotal = 0;
        $lulusTotal = 0;
        $tmlelangs = Tmlelang::select('id', 'n_lelang')->where('c_status', 1)->get();
        foreach($tmlelangs as $row=>$tmlelang)
        {
            $n_lelang = str_limit(strip_tags($tmlelang->n_lelang), 30);
            $pelamar = Tmpelamar::select('id')->where('tmlelang_id', $tmlelang->id)->count();
            $lulus = Tmpelamar::select('id')->where('tmlelang_id', $tmlelang->id)->where('tmpelamar_status_id', 3)->count();
            $tolak = Tmpelamar::select('id')->where('tmlelang_id', $tmlelang->id)->where('tmpelamar_status_id', 406)->count();
            $proses = $pelamar - ($lulus + $tolak);

            $pelamarTotal += $pelamar;
            $lulusTotal += $lulus;
            $tolakTotal += $tolak;
            $prosesTotal += $proses;

            $data[] = [
                'y' => $n_lelang,
                'a' => $pelamar,
                'b' => $proses,
                'c' => $tolak,
                'd' => $lulus
            ];
        }
        $return = [
            'lowonganTotal' => $tmlelangs->count(),
            'pelamarTotal' => $pelamarTotal,
            'prosesTotal' => $prosesTotal,
            'tolakTotal' => $tolakTotal,
            'lulusTotal' => $lulusTotal,
            'grafik' => $data
        ];
        return json_encode($return);
    }
}
