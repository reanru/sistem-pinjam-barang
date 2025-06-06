<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanBarang;
use App\Models\BarangPinjam;
use Carbon\Carbon;
use Auth;

class StatusPeminjamanController extends Controller
{

    public function index()
    {
        $daftarPeminjaman = PeminjamanBarang::where('user_id',Auth::id())->where('status','sementara')->get();
        $cekKadaluarsa = PeminjamanBarang::where('status','sementara')->whereDate('selesai', '<', Carbon::now()->format('Y-m-d'))->count();

        foreach ($daftarPeminjaman as $value) {
            $value->kadaluarsa = Carbon::now()->format('Y-m-d') > $value->selesai ? true : false;

            $barang = BarangPinjam::leftJoin('barang','barang_pinjam.barang_id','barang.id')
                                    ->where('barang_pinjam.peminjaman_id',$value->id)
                                    ->select(
                                        'barang.nama as nama_barang',
                                        'barang_pinjam.qty as jumlah'
                                    )
                                    ->get();

            $value->barang = $barang;

        }

        // dd($cekKadaluarsa);

        return view('pages.status-peminjaman.index', compact('daftarPeminjaman','cekKadaluarsa'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
