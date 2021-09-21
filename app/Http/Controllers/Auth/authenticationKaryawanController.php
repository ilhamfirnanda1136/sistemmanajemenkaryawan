<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{karyawan};

use Session,Validator,Hash;

class authenticationKaryawanController extends Controller
{
    /* logic login */
    public function loginView() 
    {
        return view('auth.login_karyawan');
    }

    public function loginProcess(Request $request) 
    {
        $karyawan = karyawan::where('username',$request->username)->first();
        if($karyawan) {
            if (!Hash::check($request->password,$karyawan->password)) 
                return redirect()->back()->with('error','mohon maaf password salah');
            else {
                $request->session()->forget('karyawan');
                $request->session()->put('karyawan',$karyawan);
                return redirect('/karyawan/dashboard');    
            }
        }
        return redirect()->back()->with('error','mohon maaf username salah');
    }

    /* logic register */
    public function registerView() 
    {
        return view('auth.register_karyawan');
    }

    protected static function validatorRegister(array $data)
    {
        return Validator::make($data,[
            'nama' => 'required','username' => 'required|unique:karyawan','tempat_lahir' => 'required','tanggal_lahir' => 'required','alamat' => 'required','jenis_kelamin' => 'required','password' => 'required'
        ]);
    } 

    public function registerProcess(Request $request) 
    {
        $validator = self::validatorRegister($request->all());
        if($validator->fails()) return response()->json(['errors'=>$validator->errors(),'message'=>'mohon mengisi data dengan benar']);
        $body = $request->all();
        $password = Hash::make($body['password']);
        $body['password'] = $password;
        karyawan::create($body);
        return response()->json(['success'=>$request->all(),'message' => 'anda telah berhasil mendaftar sebagai karyawan'], 200);
    }
}
