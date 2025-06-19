<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Indikator;


class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        return view('admin.dashboard', [
            'routeName' => 'admin.dashboard',
        ]);
    }

    // Halaman Indikator
    public function indikator()
    {
        $dataIndikator = Indikator::with('area')->get();
        return view('admin.indikator', [
            'role' => 'admin',
            'tahunList' => range(2020, date('Y')),
            'routeName' => 'admin.indikator',
            'dataIndikator' => $dataIndikator,
        ]);
    }

    // Halaman Validasi
    public function validasi()
    {
        return view('admin.validasi', [
            'routeName' => 'admin.validasi',
        ]);
    }

    // Halaman Hasil
    public function hasil()
    {
        return view('admin.hasil', [
            'routeName' => 'admin.hasil',
        ]);
    }

    // Halaman Area (opsional)
    public function area($area)
    {
        if (!in_array($area, [1, 2, 3, 4, 5, 6])) {
            abort(404);
        }

        return view("admin.area{$area}", [
            'routeName' => "admin.area{$area}",
        ]);
    }
}
