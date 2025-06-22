<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Indikator;
use App\Models\Jawaban;
use App\Models\Periode;

class ManagerIndikatorController extends Controller
{
    public function index($area, $kategori, Request $request)
    {
        $periode = Periode::latest()->first();

        $indikators = Indikator::with(['area', 'subArea', 'opsiJawaban'])
            ->where('area_id', $area)
            ->where('kategori', $kategori)
            ->where('is_published', true)
            ->where('periode_id', $periode->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('manager-area.indikator.index', [
            'indikators' => $indikators,
            'periode' => $periode,
            'kategori' => $kategori,
            'area' => $area,
            'currentKategori' => $kategori,
            'areaId' => $area,
        ]);
    }
    public function togglePublish($id)
    {
        $indikator = Indikator::findOrFail($id);

        // Isi periode_id jika belum ada
        if (!$indikator->periode_id) {
            $periode = Periode::latest()->first();
            $indikator->periode_id = $periode->id;
        }

        $indikator->is_published = !$indikator->is_published;
        $indikator->save();

        return redirect()->back()->with('success', 'Status publish indikator diperbarui.');
    }
}
