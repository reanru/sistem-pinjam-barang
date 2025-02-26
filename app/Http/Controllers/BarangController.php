<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use DB, DataTables, Validator;

class BarangController extends Controller
{
    public function index()
    {
        return view('pages.barang.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {            
            $rules = [
                'kode' => 'required',
                'nama' => 'required',
                'stok' => 'required',
            ];
    
            $messages  = [
                'kode.required' => 'Kode : Tidak boleh kosong.',
                'nama.required' => 'Nama : Tidak boleh kosong.',
                'stok.required' => 'Stok : Tidak boleh kosong.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
        
            if($validator->fails()) {
                return response()->json(['status'=>'validation error','message'=>$validator->messages()],400);
            }else{                 
                Barang::create([
                    'kode' => $request->kode,
                    'nama' => $request->nama,
                    'stok' => $request->stok,
                    'status' => 'aktif'
                ]);

                DB::commit();
                return response()->json(['status'=>'success', 'message'=>'Berhasil disimpan.'],200);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json(['status'=>'failed','message'=>$th->getMessage()],500);
        }
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
        DB::beginTransaction();

        // var_dump("check : ", $request->password);
        try {
            $rules = [
                'kode' => 'required',
                'nama' => 'required',
                'stok' => 'required',
            ];
    
            $messages  = [
                'kode.required' => 'Kode : Tidak boleh kosong.',
                'nama.required' => 'Nama : Tidak boleh kosong.',
                'stok.required' => 'Stok : Tidak boleh kosong.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
        
            if($validator->fails()) {
                return response()->json(['status'=>'validation error','message'=>$validator->messages()],400);
            }else{                
                $data = [
                    'kode' => $request->kode,
                    'nama' => $request->nama,
                    'stok' => $request->stok,
                    'status' => $request->status,
                ];

                Barang::where('id',$id)->update($data);
    
                DB::commit();
                return response()->json(['status'=>'success', 'message'=>'Berhasil disimpan.'],200);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json(['status'=>'failed','message'=>$th->getMessage()],500);
        }
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
                return $data->status;
            })
            ->addColumn('status', function ($data) {
                if($data->status === 'aktif') return '<h6><span class="badge badge-info">Aktif</span></h6>';
                else if($data->status === 'tidak-aktif') return '<h6><span class="badge badge-warning">Tidak Aktif</span></h6>';
            })
            ->addColumn('action', function($data){
                return '
                    <a href="javascript:void(0)" data-toggle="tooltip"
                        data-id="'.$data->id.'" 
                        data-kode="'.$data->kode.'" 
                        data-nama="'.$data->nama.'" 
                        data-stok="'.$data->stok.'" 
                        data-status="'.$data->status.'" 
                        data-original-title="Edit" class="edit btn btn-primary btn-sm show-edit-modal"><i class="fas fa-edit"></i></a>
                ';
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }
}
