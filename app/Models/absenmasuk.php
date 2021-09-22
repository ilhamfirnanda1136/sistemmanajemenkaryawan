<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absenmasuk extends Model
{
    use HasFactory;
    protected $table = 'absenmasuk';
    protected $fillable = ['karyawan_id','lat','lang','status'];
    
    public function karyawan()
    {
        return $this->belongsTo(karyawan::class);
    }

    public function absenkeluar()
    {
        return $this->hasOne(absenkeluar::class);
    }
}
