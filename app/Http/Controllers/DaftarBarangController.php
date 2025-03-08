<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use DB, DataTables, Validator;

class DaftarBarangController extends Controller
{

    public function index()
    {
        return view('pages.daftar-barang.index');
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
        $data = DB::table('barang')
                        ->orderBy('created_at', 'DESC')
                        ->select(
                            'id',
                            'kode',
                            'nama',
                            'stok',
                            'status'
                        )->get();

        return Datatables::of($data)->addIndexColumn()
            ->addIndexColumn()
            ->addColumn('kode', function ($data) {
                return $data->kode;
            })
            ->addColumn('nama', function ($data) {
                return $data->nama;
            })
            ->addColumn('stok', function ($data) {
                return $data->stok;
            })
            ->addColumn('status', function ($data) {
                if($data->status === 'aktif') return '<h6><span class="badge badge-info">Aktif</span></h6>';
                else if($data->status === 'tidak-aktif') return '<h6><span class="badge badge-warning">Tidak Aktif</span></h6>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }
}
