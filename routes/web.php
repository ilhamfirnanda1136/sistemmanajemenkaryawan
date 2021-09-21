<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\{authenticationKaryawanController};


Route::get('/', function () {
    return redirect('/karyawan/login');
});

/* Authentication Karyawan */
Route::prefix('karyawan')->group(function () {
    Route::get('login',[authenticationKaryawanController::class,'loginView']);
    Route::post('login',[authenticationKaryawanController::class,'loginProcess'])->name('login');
    Route::get('register',[authenticationKaryawanController::class,'registerView']);
    Route::post('register',[authenticationKaryawanController::class,'registerProcess'])->name('register');
});

/* After Authentication Karyawan */
Route::middleware(['karyawan'])->group(function () {

    Route::prefix('karyawan')->group(function () {
        /* Authentication LogOUt */
        Route::get('logout',function(Request $request){
            $request->session()->forget('karyawan');
            return redirect('karyawan/login');
        });

        /* Dashboard */
        Route::get('dashboard',function(){
            return 'anda sudah login';
        });
    });

});

