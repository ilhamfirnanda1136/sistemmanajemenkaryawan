<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absenkeluar extends Model
{
    use HasFactory;
    protected $table = 'absenkeluar';
    protected $fillable = ['absenmasuk_id','lat','lang','status'];

    public function absenmasuk()
    {
        return $this->belongsTo(absenmasuk::class);
    }
}
