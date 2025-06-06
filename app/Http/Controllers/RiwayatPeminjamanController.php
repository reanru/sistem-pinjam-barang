<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanBarang;
use App\Models\BarangPinjam;
use DB, Auth, DataTables, Validator;

class RiwayatPeminjamanController extends Controller
{

    public function index()
    {
        return view('pages.riwayat-peminjaman.index');
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

    public function datatable(){
        // mengambil data
        $data = DB::table('peminjaman_barang')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'DESC')
                        ->select(
                            'id',
                            'mulai',
                            'selesai',
                            'deskripsi',
                            'status'
                        )->get();

        foreach ($data as $value) {
            $barang = BarangPinjam::leftJoin('barang','barang_pinjam.barang_id','barang.id')
                                    ->where('barang_pinjam.peminjaman_id',$value->id)
                                    ->select(
                                        'barang.nama as nama_barang',
                                        'barang_pinjam.qty as jumlah'
                                    )
                                    ->get();

            $value->barang = $barang;
        }

        return Datatables::of($data)->addIndexColumn()
            ->addIndexColumn()
            ->addColumn('barang', function ($data) {
                $temp = '';

                foreach ($data->barang as $value) {
                    $temp = $temp.'<li>'. $value->nama_barang ?? '-'.' ~ Jumlah : '. $value->jumlah ?? '-' .'</li>';
                }
                return '<ul style="padding:0px">'.$temp.'<ul>';
            })
            ->addColumn('mulai', function ($data) {
                return $data->mulai;
            })
            ->addColumn('selesai', function ($data) {
                return $data->selesai;
            })
            ->addColumn('deskripsi', function ($data) {
                return $data->deskripsi;
            })
            ->addColumn('status', function ($data) {
                if($data->status === 'sementara') return '<h6><span class="badge badge-info">Proses</span></h6>';
                else if($data->status === 'selesai') return '<h6><span class="badge badge-success">Selesai</span></h6>';
                else if($data->status === 'dibatalkan') return '<h6><span class="badge badge-warning">Batal</span></h6>';
            })
            // ->addColumn('action', function($data){
            //     return '
            //         <a href="javascript:void(0)" data-toggle="tooltip"
            //             data-id="'.$data->id.'" 
            //             data-kode="'.$data->kode.'" 
            //             data-nama="'.$data->nama.'" 
            //             data-stok="'.$data->stok.'" 
            //             data-status="'.$data->status.'" 
            //             data-original-title="Edit" class="edit btn btn-primary btn-sm show-edit-modal"><i class="fas fa-edit"></i></a>
            //     ';
            // })
            ->rawColumns(['barang','status','action'])
            ->make(true);
    }
}
