<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Method dashboard untuk admin
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function indikator()
    {
        return view('admin.indikator');
    }


}
