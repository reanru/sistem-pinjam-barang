<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanBarang;
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
                            'kode_barang',
                            'nama_barang',
                            'mulai',
                            'selesai',
                            'deskripsi',
                            'status'
                        )->get();

        return Datatables::of($data)->addIndexColumn()
            ->addIndexColumn()
            ->addColumn('kode_barang', function ($data) {
                return $data->kode_barang;
            })
            ->addColumn('nama_barang', function ($data) {
                return $data->nama_barang;
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
                if($data->status === 'sementara') return '<h6><span class="badge badge-info">Aktif</span></h6>';
                else if($data->status === 'selesai') return '<h6><span class="badge badge-warning">Tidak Aktif</span></h6>';
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
            ->rawColumns(['status','action'])
            ->make(true);
    }
}
