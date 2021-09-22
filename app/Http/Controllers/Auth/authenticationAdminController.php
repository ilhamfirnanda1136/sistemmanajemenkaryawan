<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{User}; 

use Auth,Hash;

class authenticationAdminController extends Controller
{
    /* Admin Authentication */
    public function loginView() 
    {
        return view('auth.login_admin');    
    }

    public function loginProcess(Request $req)
    {
        $req->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('username',$req->username)->first();
        if(!$user) return redirect()->back()->with('error','mohon maaf username yang anda masukkan salah');
        if(!Auth::attempt(['username' => $req->username, 'password' => $req->password]))  return redirect()->back()->with('error','mohon maaf password yang anda masukkan salah');
        return redirect('admin/home');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('admin/login');
    }
}
