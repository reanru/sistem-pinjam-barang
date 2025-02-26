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
                'email' => 'required|unique:users',
                'no_hp' => 'required',
            ];
    
            $messages  = [
                'name.required' => 'Nama : Tidak boleh kosong.',
                'email.required' => 'Email : Tidak boleh kosong.',
                'email.unique' => 'Email : Telah digunakan.',
                'no_hp.required' => 'No HP : Tidak boleh kosong.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
        
            if($validator->fails()) {
                return response()->json(['status'=>'validation error','message'=>$validator->messages()],400);
            }else{                 
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                    'password' => bcrypt('pengguna123'),
                    'role' => 'pengguna'
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
                'no_hp' => 'required',
            ];

            $messages  = [
                'email.required' => 'Email : Tidak boleh kosong.',
                'email.unique' => 'Email : Telah digunakan.',
                'name.required' => 'Nama : Tidak boleh kosong.',
                'no_hp.required' => 'No HP : Tidak boleh kosong.',
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
                    'email' => $request->email,
                    'name' => $request->name,
                    'no_hp' => $request->no_hp,
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
                        ->where('role','pengguna')
                        ->orderBy('created_at', 'DESC')
                        ->select(
                            'id',
                            'name',
                            'email',
                            'no_hp'
                        )->get();

        return Datatables::of($userList)->addIndexColumn()
            ->addIndexColumn()
            ->addColumn('name', function ($userList) {
                return $userList->name;
            })
            ->addColumn('email', function ($userList) {
                return $userList->email;
            })
            ->addColumn('no_hp', function ($userList) {
                return $userList->no_hp;
            })
            ->addColumn('action', function($userList){
                return '
                    <a href="javascript:void(0)" data-toggle="tooltip"
                        data-id="'.$userList->id.'" 
                        data-name="'.$userList->name.'" 
                        data-email="'.$userList->email.'" 
                        data-no_hp="'.$userList->no_hp.'" 
                        data-original-title="Edit" class="edit btn btn-primary btn-sm show-edit-modal"><i class="fas fa-edit"></i></a>
                ';
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }
}
