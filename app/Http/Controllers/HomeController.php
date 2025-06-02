<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\BarangPinjam;
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

            $peminjaman = PeminjamanBarang::leftJoin('users','peminjaman_barang.user_id','users.id')
                                            ->where('peminjaman_barang.status', 'sementara')
                                            ->select(
                                                'peminjaman_barang.id',
                                                'users.name as nama_user',
                                            )
                                            ->get();
            foreach ($peminjaman as $value) {
                $barang = BarangPinjam::leftJoin('barang','barang_pinjam.barang_id','barang.id')
                                        ->where('barang_pinjam.peminjaman_id',$value->id)
                                        ->select(
                                            'barang.nama as nama_barang',
                                            'barang_pinjam.qty as jumlah'
                                        )
                                        ->get();

                $value->barang = $barang;
            }

            // dd($peminjaman);

            return view('home', compact('peminjaman','countBarang','countUser','countRiwayatPeminjamanBarangSementara','countRiwayatPeminjamanBarangDibatalkan','countRiwayatPeminjamanBarangSelesai'));
        }

        if(Auth::user()->role === 'pengguna'){     
            $countBarang = Barang::count();
            $countRiwayatPeminjamanBarang = PeminjamanBarang::where('user_id', Auth::id())->count();

            return view('home', compact('countBarang','countRiwayatPeminjamanBarang'));
        }
    }

    public function umum(){
        // $stokBarang = Barang::get(['nama','stok']);
        $barang = Barang::get();
        return view('pages.umum.index', compact('barang'));
    }
}
