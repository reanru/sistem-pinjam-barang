<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        $countBarang = Barang::count();
        
        if(Auth::user()->role === 'admin'){
            $countUser = User::count();
            $countRiwayatPeminjamanBarangSementara = PeminjamanBarang::where('status', 'sementara')->count();
            $countRiwayatPeminjamanBarangDibatalkan = PeminjamanBarang::where('status', 'dibatalkan')->count();
            $countRiwayatPeminjamanBarangSelesai = PeminjamanBarang::where('status', 'selesai')->count();

            $stokBarang = Barang::get(['nama','stok']);

            // dd($stokBarang);

            return view('home', compact('stokBarang','countBarang','countUser','countRiwayatPeminjamanBarangSementara','countRiwayatPeminjamanBarangDibatalkan','countRiwayatPeminjamanBarangSelesai'));
        }

        if(Auth::user()->role === 'pengguna'){     
            $countBarang = Barang::count();
            $countRiwayatPeminjamanBarang = PeminjamanBarang::where('user_id', Auth::id())->count();

            return view('home', compact('countBarang','countRiwayatPeminjamanBarang'));
        }
    }

    public function umum(){
        $barang = Barang::get();
        return view('pages.umum.index', compact('barang'));
    }
}
