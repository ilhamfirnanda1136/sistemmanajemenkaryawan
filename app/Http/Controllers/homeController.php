<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{   
    public function indexKaryawan()
    {
        return view('karyawan.home.home_view');
    }

    public function indexAdmin()
    {
        return view('admin.home.home_view');
    }
}
