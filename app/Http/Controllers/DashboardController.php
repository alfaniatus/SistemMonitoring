<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($area)
    {
        $areaName = 'Area ' . strtoupper($area);
        $areaCode = 'area' . $area;

        $viewName = "manager-area.area.area{$area}";

        if (!view()->exists($viewName)) {
            abort(404, 'Halaman area tidak ditemukan.');
        }

        $user = Auth::user();
        $role = $user ? $user->getRoleNames()->first() : null;
        $areaUser = $user ? $user->name : 'Guest';

        return view($viewName, compact('areaName', 'areaCode', 'role', 'areaUser'));
    }
}
