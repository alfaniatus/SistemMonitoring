<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Indikator;
use App\Models\Periode;
use Illuminate\Support\Facades\DB;

class ManagerIndikatorController extends Controller
{
public function index($area, $kategori, Request $request)
{
    $periodeId = $request->input('periode_id') ?? Periode::latest()->first()->id;
    $periode = Periode::find($periodeId);
    $areaId = $area;

    $indikators = Indikator::with(['area', 'subArea', 'opsiJawaban'])
        ->where('area_id', $areaId)
        ->where('kategori', $kategori)
        ->whereExists(function ($query) use ($periodeId) {
            $query->select(DB::raw(1))
                ->from('indikator_periode')
                ->whereColumn('indikator_periode.indikator_id', 'indikators.id')
                ->where('indikator_periode.periode_id', $periodeId)
                ->where('indikator_periode.published', 1);  
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return view('manager-area.indikator.index', [
        'indikators' => $indikators,
        'periode' => $periode,
        'kategori' => $kategori,
        'area' => $area,
        'currentKategori' => $kategori, 
    ]);
}

    public function togglePublish(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|exists:indikators,id',
            'periode_id' => 'required|exists:periodes,id',
        ]);

        $indikatorId = $request->input('indikator_id');
        $periodeId = $request->input('periode_id');

        $pivot = DB::table('indikator_periode')
            ->where('indikator_id', $indikatorId)
            ->where('periode_id', $periodeId)
            ->first();

        if ($pivot) {
            DB::table('indikator_periode')
                ->where('indikator_id', $indikatorId)
                ->where('periode_id', $periodeId)
                ->update(['published' => !$pivot->published, 'updated_at' => now()]);
        } else {
            DB::table('indikator_periode')->insert([
                'indikator_id' => $indikatorId,
                'periode_id' => $periodeId,
                'published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Status publish indikator diperbarui.');
    }
} 