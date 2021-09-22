<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';

    protected $fillable = ['nama','username','tempat_lahir','tanggal_lahir','alamat','jenis_kelamin','password'];

    public function absenmasuk() 
    {
        return $this->hasMany(absenmasuk::class);
    }

    public function ketidakhadiran()
    {
        return $this->hasMany(ketidakhadiran::class);
    }

}
