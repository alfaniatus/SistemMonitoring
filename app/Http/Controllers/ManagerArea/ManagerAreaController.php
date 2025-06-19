<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Indikator;

class ManagerAreaController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $areaUser = $user->area;
        $areaId = $user->area_id;

        return view('manager-area.dashboard', [
            'role' => 'manager',
            'areaUser' => $user->area,
            'areaId' => $user->area_id,

        ]);
    }

    public function indikator()
    {
        $user = auth()->user();
        $areaUser = $user->area;
        $areaId = $user->area_id;

        $dataIndikator = Indikator::where('area_id', $areaId)->get();

        return view('manager-area.indikator', [
            'areaUser' => $areaUser,
            'areaId' => $areaId,
            'user' => $user,
            'role' => 'manager',
            'routeName' => 'manager-area.indikator',
            'dataIndikator' => $dataIndikator,
        ]);
    }
}
