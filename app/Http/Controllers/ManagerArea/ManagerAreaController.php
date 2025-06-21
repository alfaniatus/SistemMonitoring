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
    public function pemenuhan()
{
    $user = Auth::user();
    $areaId = $user->area_id;

    $periodeAktif = Periode::orderByDesc('tahun')->first(); // misal: tahun terbaru

    $indikators = Indikator::where('is_published', true)
        ->where('area_id', $areaId)
        ->where('kategori', 'pemenuhan')
        ->where('periode_id', $periodeAktif->id)
        ->get();

    return view('manager.pemenuhan', compact('indikators', 'periodeAktif'));
}

}
