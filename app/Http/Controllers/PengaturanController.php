<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use DB, Auth, Validator;

class PengaturanController extends Controller
{
    public function index()
    {
        $data = User::where('id',Auth::id())->first();

        return view('pages.pengaturan.index', compact('data'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        // var_dump("check : ", $request->password);
        try {
            $rules = [
                'password' => 'required'
            ];

            $messages  = [
                'password.required' => 'Password : Tidak boleh kosong.'
            ];

            $request->validate($rules, $messages);

            $data = [
                'password' => bcrypt($request->password)
            ];

            User::where('id',Auth::id())->update($data);

            Alert::success('Berhasil', "Berhasil disimpan.");
            DB::commit();
            
            return redirect()->route('pengaturan.index');
            
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Terjadi kesalahan', $th->getMessage());
            DB::rollback();
            return back();
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
                'name' => 'required',
                'no_hp' => 'required',
            ];

            $messages  = [
                'name.required' => 'Nama : Tidak boleh kosong.',
                'no_hp.required' => 'No HP : Tidak boleh kosong.',
            ];

            $request->validate($rules, $messages);

            $data = [
                'name' => $request->name,
                'no_hp' => $request->no_hp,
            ];

            User::where('id',Auth::id())->update($data);

            Alert::success('Berhasil', "Berhasil disimpan.");
            DB::commit();
            
            return redirect()->route('pengaturan.index');
            
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Terjadi kesalahan', $th->getMessage());
            DB::rollback();
            return back();
        }
    }

    public function destroy($id)
    {
        //
    }
}
