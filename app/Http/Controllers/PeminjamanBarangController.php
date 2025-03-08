<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanBarang;
use DB, Auth, DataTables, Validator;

class PeminjamanBarangController extends Controller
{

    public function index()
    {
        return view('pages.peminjaman-barang.index');
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

    // Ambil data kategori untuk Select2
    public function search(Request $request)
    {
        $search = $request->input('q');

        $categories = DB::table("users")->where('name', 'LIKE', "%{$search}%")
            ->get(['id', 'name']);

        return response()->json($categories);
    }

    public function datatable(){
        // mengambil data
        $data = DB::table('peminjaman_barang')
                        ->leftJoin('users','peminjaman_barang.user_id','users.id')
                        ->orderBy('peminjaman_barang.created_at', 'DESC')
                        ->select(
                            'peminjaman_barang.id',
                            'kode_barang',
                            'users.name as nama_user',
                            'nama_barang',
                            'mulai',
                            'selesai',
                            'deskripsi',
                            'peminjaman_barang.status'
                        )->get();

        return Datatables::of($data)->addIndexColumn()
            ->addIndexColumn()
            ->addColumn('nama_user', function ($data) {
                return $data->nama_user;
            })
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
