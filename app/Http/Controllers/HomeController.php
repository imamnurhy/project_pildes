<?php

namespace App\Http\Controllers;

use App\Models\Tmasets;
use App\Models\Tmjenis_aset;
use Illuminate\Http\Request;
use App\Models\Tmlelang;
use App\Models\Tmmerk;
use App\Models\Tmopd_aset;
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
        $tmmerk = Tmmerk::all()->count();
        $tmjenis_aset = Tmjenis_aset::all()->count();
        $tmaset = Tmasets::all()->count();
        $tmopd_aset = Tmopd_aset::all()->count();

        return view('home', compact('tmmerk', 'tmjenis_aset', 'tmaset', 'tmopd_aset'));
    }
}
