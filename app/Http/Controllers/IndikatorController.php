<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tahun;

class IndikatorController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        // ambil semua tahun untuk filter indikator
        $tahunList = Tahun::orderBy('tahun', 'desc')->pluck('tahun');

        // route indikator untuk sidebar, dikirim ke view
        $indikatorRoute = $role === 'admin'
            ? route('admin.indikator')
            : route('manager-area.indikator');

        // tentukan view mana yang mau dipakai
        $viewName = $role === 'admin' ? 'admin.indikator' : 'manager-area.indikator';

        return view($viewName, [
            'tahunList' => $tahunList,
            'indikatorRoute' => $indikatorRoute,
            'role' => $role
        ]);
    }
}
