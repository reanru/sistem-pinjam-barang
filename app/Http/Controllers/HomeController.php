<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\PeminjamanBarang;
use Auth, DB, Carbon\Carbon;

class HomeController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        Carbon::setLocale('id');
    }

    public function index()
    {

        if(Auth::user()->role === 'admin'){     
            return view('home', compact());
        }

        if(Auth::user()->role === 'pengguna'){     
            $countBarang = Barang::count();
            $countRiwayatPeminjamanBarang = PeminjamanBarang::where('user_id', Auth::id())->count();

            return view('home', compact('countBarang','countRiwayatPeminjamanBarang'));
        }
    }
}
