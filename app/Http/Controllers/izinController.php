<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    ketidakhadiran
};

use Carbon\Carbon;

use Validator,Session,DataTables;

class izinController extends Controller
{
    public function index()
    {
        return view('karyawan.izin.izin_view');
    }

    protected static function validator(array $data)
    {
        return Validator::make($data,[
            'jenis_ijin' => 'required','keterangan' => 'required','tanggal_ijin' => 'required'
        ]);
    }

    public function table(Request $request)
    {
        $tanggal = $request->tanggal;
        $model = ketidakhadiran::when($tanggal != null,function($query) use ($tanggal) {
            return $query->whereDate('created_at',$tanggal);
        })->with(['karyawan'])->where('karyawan_id',Session::get('karyawan')->id)->orderBy('id','desc');
        return DataTables::of($model)
        ->addColumn('jenisijin',function($model){
            return $model->jenis_ijin == 1 ? 'Izin Sakit' : 'Izin Cuti';
        })
        ->addColumn('status_ijin',function($model){
            return $model->status == 1 ? '<span class="badge badge-success">Telah diapprove</span>' : '<span class="badge badge-success">Belum diapprove</span>';
        })
        ->addIndexColumn()
         ->rawColumns(['jenisijin','status_ijin'])
        ->make(true);
    }

    public function processIzin(Request $request)
    {
        $body = $request->all();
        $validator = self::validator($body);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors(),'message'=>'mohon isi form dengan benar']);
        $jenisIzin = $body['jenis_ijin'];
        $body['karyawan_id'] = Session::get('karyawan')->id;
        $tgl1 = strtotime(date("Y-m-d")); 
        $tgl2 = strtotime($body['tanggal_ijin']); 
        $jarak = $tgl1 - $tgl2;
        $hari = $jarak / 60 / 60 / 24;
        $body['status'] = 2;
        switch ($jenisIzin) {
            case '1':
                if($hari > 3) {
                    return response()->json(['success'=>$request->all(),'message'=>'mohon maaf maksimal untuk Penginputan izin sakit adalah H+3','icon'=>'error']);
                }
                break;
            case '2':
                if($hari > -1) {
                    return response()->json(['success'=>$request->all(),'message'=>'mohon maaf maksimal untuk Penginputan izin Cuti adalah H-1','icon'=>'error']);
                }
                break;
        }
        ketidakhadiran::create($body);
        return response()->json(['success'=>$request->all(),'message'=>'anda telah berhasil menginput permohonan ijin ketidak hadiran mohon menunggu approval dari manager/atasan anda','icon'=>'success']);
    }

    public function riwayatIzin(Request $request)
    {
        $bulan = $request->has('bulan') ? $request->has('bulan') : date('m');
        $tahun = $request->has('tahun') ? $request->has('tahun') : date('Y');
        $izin = ketidakhadiran::with(['karyawan'])->whereYear('created_at',$tahun)->whereMonth('created_at',$bulan)->orderBy('id','desc')->get();
        return view('admin.izin.izin_view',compact('bulan','tahun','izin'));
    }

    public function approveIzin($id)
    {
        $izin = ketidakhadiran::findOrFail($id);
        $izin->status = 1;
        $izin->save();
        return redirect()->back()->with('sukses','anda telah berhasil melakukan approval permohonan ijin karyawan');
    }

    public function grafikIzin($bulan,$tahun)
    {
        $data = [];
        for($m=1;$m<=cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);$m++) {
            $izin = ketidakhadiran::whereDay('created_at',$m)->count();
            array_push($data,$izin);
        }
        return response()->json(['data'=> $data]);
    }
}
