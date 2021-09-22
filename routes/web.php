<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\{
    authenticationKaryawanController,authenticationAdminController
};
use App\Http\Controllers\{
    homeController,absenController,izinController
};

/* Karyawan */

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
        Route::get('dashboard',[homeController::class,'indexKaryawan']);

        /* Absen Masuk */
        Route::get('absen/masuk',[absenController::class,'indexAbsenMasuk']);
        Route::post('absen/masuk',[absenController::class,'processAbsenMasuk']);
        
        /* Absen Keluar */
        Route::get('absen/keluar',[absenController::class,'indexAbsenKeluar']);
        Route::post('absen/keluar',[absenController::class,'processAbsenKeluar']);

        /* Pengajuan Ketidak Hadiran (Izin) */  
        Route::get('izin',[izinController::class,'index']);
        Route::post('izin',[izinController::class,'processIzin']);
        Route::get('izin/table',[izinController::class,'table']);

        /* Riwayat Absen */
        Route::get('riwayat/absen',[absenController::class,'riwayatAbsen']);
    
    });
});


/* Admin (HRD/ATASAN) */

/* Authentication HRD ATASAN */
Route::prefix('admin')->group(function () {
    Route::get('login',[authenticationAdminController::class,'loginView']);
    Route::post('login',[authenticationAdminController::class,'loginProcess']);
});


/* After Authentication HRD ATASAN */
Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {
        /* Authentication LogOUt */
        Route::get('logout',[authenticationAdminController::class,'logout']);

        /* home */
        Route::get('home',[homeController::class,'indexAdmin']);

        /*  Absen */
        Route::get('absen',[absenController::class,'riwayatAbsenAdmin']);
        Route::get('grafik/karyawan/{bulan}/{tahun}',[absenController::class,'grafikAbsen']);

        /* Permohonan Izin */
        Route::get('izin',[izinController::class,'riwayatIzin']);
        Route::get('izin/approve/{id}',[izinController::class,'approveIzin']);
        Route::get('izin/grafik/karyawan/{bulan}/{tahun}',[izinController::class,'grafikIzin']);
    });

});


