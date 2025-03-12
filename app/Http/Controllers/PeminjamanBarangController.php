<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\PeminjamanBarang;
use Carbon\Carbon;
use DB, Auth, DataTables, Validator;

class PeminjamanBarangController extends Controller
{

    public function index()
    {
        $daftarBarang = Barang::where('status','aktif')->get(['id','nama','kode','stok']);
        return view('pages.peminjaman-barang.index', compact('daftarBarang'));
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
                'user_id' => 'required',
                'no_hp' => 'required',
                'barang' => 'required',
                'mulai' => 'required',
                'selesai' => 'required',
            ];
    
            $messages  = [
                'user_id.required' => 'Pengguna : Tidak boleh kosong.',
                'no_hp.required' => 'No HP : Tidak boleh kosong.',
                'barang.required' => 'Barang : Tidak boleh kosong.',
                'mulai.required' => 'Mulai : Tidak boleh kosong.',
                'selesai.required' => 'Selesai : Tidak boleh kosong.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
        
            if($validator->fails()) {
                return response()->json(['status'=>'validation error','message'=>$validator->messages()],400);
            }else{    
                // return response()->json(['status'=>'success', 'test'=>$request->all()],500); 

                $pengguna = explode("~",$request->user_id);
                $barang = explode("~",$request->barang);

                // jika sementara meminjam barang A, tidak boleh meminjam barang yang sama
                $check1 = PeminjamanBarang::where('user_id',$pengguna[0])->where('barang_id',$barang[0])->where('status','sementara')->first();
                if($check1){
                    return response()->json(['status'=>'validation error','message'=>['Tidak dapat membuat permintaan, pengguna ini sementara meminjam <strong>'.$barang[2].'</strong>.']],400);
                }


                // jika semntara meminjam barang A (sudah lewat batas peminjaman dan belum dikembalikan), tidak boleh meminjam barang lain 
                $check2 = PeminjamanBarang::where('user_id',$pengguna[0])->where('status','sementara')->first();
                if($check2 !== null && Carbon::now()->format('Y-m-d') > $check2?->selesai){
                    return response()->json(['status'=>'validation error','message'=>['Tidak dapat membuat permintaan, pengguna ini sementara meminjam <strong>'.$check2?->nama_barang.'</strong>, dengan kondisi telah melewati batas waktu peminjaman dan belum dikembalikan.']],400);
                }

                PeminjamanBarang::create([
                    'user_id' => $pengguna[0],
                    'no_hp' => $request->no_hp,
                    'barang_id' => $barang[0],
                    'kode_barang' => $barang[1],
                    'nama_barang' => $barang[2],
                    'mulai' => $request->mulai,
                    'selesai' => $request->selesai,
                    'deskripsi' => $request->deskripsi,
                    'status' => 'sementara'
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
        //
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            PeminjamanBarang::find($id)->update(['status'=>'dibatalkan']);

            DB::commit();
            return response()->json(['status'=>'success', 'message'=>'Berhasil dibatalkan.'],200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json(['status'=>'failed','message'=>$th->getMessage()],500);
        }
    }

    // Ambil data kategori untuk Select2
    public function search(Request $request)
    {
        $search = $request->input('q');

        $categories = DB::table("users")->where('name', 'LIKE', "%{$search}%")
            ->get(['id', 'name', 'no_hp']);

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
                return $data->deskripsi ?? '-';
            })
            ->addColumn('status', function ($data) {
                if($data->status === 'sementara') return '<h6><span class="badge badge-info">Sementara</span></h6>';
                else if($data->status === 'selesai') return '<h6><span class="badge badge-success">Selesai</span></h6>';
                else if($data->status === 'dibatalkan') return '<h6><span class="badge badge-warning">Dibatalkan</span></h6>';
            })
            ->addColumn('action', function($data){
                if($data->status === 'sementara'){
                    return '
                        <a href="javascript:void(0)" data-toggle="tooltip"
                            data-id="'.$data->id.'" 
                            data-original-title="Edit" class="edit btn btn-primary btn-sm show-delete-modal"><i class="fas fa-times"></i></a>
                    ';
                }else{
                    return '';
                }
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }
}
