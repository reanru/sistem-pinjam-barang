<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB, DataTables, Validator;

class UserController extends Controller
{

    public function index()
    {
        return view('pages.user.index');
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
                'name' => 'required',
                'kolom' => 'required',
                'email' => 'required|unique:users',
            ];
    
            $messages  = [
                'name.required' => 'Nama : Tidak boleh kosong.',
                'nim.required' => 'Kolom : Tidak boleh kosong.',
                'email.required' => 'Email : Tidak boleh kosong.',
                'email.unique' => 'Email : Email telah digunakan.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
        
            if($validator->fails()) {
                return response()->json(['status'=>'validation error','message'=>$validator->messages()],400);
            }else{                 
                User::create([
                    'name' => $request->name,
                    'kolom' => $request->kolom,
                    'email' => $request->email,
                    'password' => bcrypt('jemaat123'),
                    'role' => 'jemaat'
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
                'email' => 'required|unique:users,email,' .$id,
                'name' => 'required',
                'kolom' => 'required',
            ];

            $messages  = [
                'email.required' => 'Email : Tidak boleh kosong.',
                'email.unique' => 'Email : Email telah digunakan.',
                'name.required' => 'Nama : Tidak boleh kosong.',
                'kolom.required' => 'Kolom : Tidak boleh kosong.',
            ];
            
            if($request->password){
                $rules += ['password' => 'required'];
                $messages += ['password.required' => 'Password : Tidak boleh kosong.',];
            }

            $validator = Validator::make($request->all(), $rules, $messages);
        
            if($validator->fails()) {
                return response()->json(['status'=>'validation error','message'=>$validator->messages()],400);
            }else{                
                $data = [
                    'kolom' => $request->kolom,
                    'email' => $request->email,
                    'name' => $request->name,
                ];

                if($request->password) $data += ['password' => bcrypt($request->password)];

                User::where('id',$id)->update($data);
    
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
        $userList = DB::table('users')
                        ->where('role','jemaat')
                        ->orderBy('created_at', 'DESC')
                        ->select(
                            'id',
                            'name',
                            'email',
                            'kolom',
                            'umur',
                            'pekerjaan',
                            'gender',
                            'status_pernikahan',
                        )->get();

        return Datatables::of($userList)->addIndexColumn()
            ->addIndexColumn()
            ->addColumn('name', function ($userList) {
                return $userList->name;
            })
            ->addColumn('email', function ($userList) {
                return $userList->email;
            })
            ->addColumn('kolom', function ($userList) {
                return $userList->kolom;
            })
            ->addColumn('action', function($userList){
                return '
                    <a href="javascript:void(0)" data-toggle="tooltip"
                        data-id="'.$userList->id.'" 
                        data-name="'.$userList->name.'" 
                        data-kolom="'.$userList->kolom.'" 
                        data-email="'.$userList->email.'" 
                        data-original-title="Edit" class="edit btn btn-primary btn-sm show-edit-modal"><i class="fas fa-edit"></i></a>
                    
                    <a href="javascript:void(0)" data-toggle="tooltip"
                        data-name="'.$userList->name.'" 
                        data-kolom="'.$userList->kolom.'" 
                        data-email="'.$userList->email.'" 
                        data-umur="'.$userList->umur.'" 
                        data-pekerjaan="'.$userList->pekerjaan.'" 
                        data-jenis_kelamin="'.$userList->gender.'"
                        data-status_pernikahan="'.$userList->status_pernikahan.'" 
                        data-original-title="Edit" class="edit btn btn-primary btn-sm show-detail-modal"><i class="fas fa-eye"></i></a>
                ';
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }
}
