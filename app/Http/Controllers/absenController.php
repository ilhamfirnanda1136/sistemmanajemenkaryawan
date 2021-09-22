<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    absenmasuk,absenkeluar
};

use Session;

class absenController extends Controller
{

    /* Logic Absen masuk */
    public function indexAbsenMasuk()
    {
        $absenmasuk = absenmasuk::whereDate('created_at',date("Y-m-d"))->first();
        if (!$absenmasuk) return view('karyawan.absen.absen_masuk');
        return view('karyawan.absen.absen_masuk_data',compact('absenmasuk'));
    }

    public function processAbsenMasuk(Request $request)
    {
        $body = $request->all();
        $body['karyawan_id'] = Session::get('karyawan')->id;
        if (date("H") >= 9) $status = 2;
        else $status = 1;
        $body['status'] = $status;
        absenmasuk::create($body);
        return response()->json(['success'=>$request->all(),'message'=>'anda telah berhasil absen masuk']);
    }

    /* Logic Absen Keluar */
    public function indexAbsenKeluar()
    {
        $absenmasuk = absenmasuk::whereDate('created_at',date("Y-m-d"))->first();
        if (!$absenmasuk) return redirect('absen/masuk');
        $absenkeluar = absenkeluar::with(['absenmasuk'])->whereDate('created_at',date("Y-m-d"))->first();
        if (!$absenkeluar) return view('karyawan.absen.absen_keluar',compact('absenmasuk'));
        return view('karyawan.absen.absen_keluar_data',compact('absenkeluar'));
    }

    public function processAbsenKeluar(Request $request)
    {
        $body = $request->all();
        if (date("H") <= 17) $status = 2;
        else $status = 1;
        $body['status'] = $status;
        absenkeluar::create($body);
        return response()->json(['success'=>$request->all(),'message'=>'anda telah berhasil absen keluar']);
    }

    /* Riwayat Absen  */
    protected function Query($bulan,$tahun,$status)
    {
        $sessionId = Session::has('karyawan')->id ?? Session::get('karyawan')->id ;
        $absen = absenmasuk::whereYear('created_at',$tahun)->whereMonth('created_at',$bulan)->when($status == 1, function($q) use($sessionId) {
            return $q->where('karyawan_id',$sessionId);
        })->get(); 
        return $absen;
    }

    public function riwayatAbsen(Request $request)
    {
        $bulan = $request->has('bulan') ? $request->has('bulan') : date('m');
        $tahun = $request->has('tahun') ? $request->has('tahun') : date('Y');
        $absen = $this->Query($bulan,$tahun,1);
        return view('karyawan.absen.riwayat_absen',compact('bulan','tahun','absen'));
    }


    public function riwayatAbsenAdmin(Request $request)
    {
        $bulan = $request->has('bulan') ? $request->has('bulan') : date('m');
        $tahun = $request->has('tahun') ? $request->has('tahun') : date('Y');
        $absen = $this->Query($bulan,$tahun,2);
        return view('admin.absen.riwayat_absen',compact('bulan','tahun','absen')); 
    }

    public function grafikAbsen($bulan,$tahun)
    {
        $data = [];
        for($m=1;$m<=cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);$m++) {
            $absen = absenmasuk::whereDay('created_at',$m)->count();
            array_push($data,$absen);
        }
        return response()->json(['data'=> $data]);
    }

}
