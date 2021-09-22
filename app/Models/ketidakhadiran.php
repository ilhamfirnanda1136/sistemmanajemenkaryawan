<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ketidakhadiran extends Model
{
    use HasFactory;
    protected $table = 'ketidakhadiran';
    protected $fillable = ['karyawan_id','jenis_ijin','keterangan','tanggal_ijin','status'];

    public function karyawan()
    {
        return $this->belongsTo(karyawan::class);
    }
}
