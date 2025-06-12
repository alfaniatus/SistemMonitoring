<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tahun; // ⬅️ pastikan ini ada

class IndikatorController extends Controller
{
    public function index()
    {
        $tahunList = Tahun::orderBy('tahun', 'desc')->pluck('tahun');
        return view('admin.indikator', compact('tahunList')); 
    }
}
