<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JawabanIndikator;
use App\Models\Periode;

class ManagerJawabanController extends Controller
{
    public function store(Request $request)
    {
        $periodeId = Periode::latest()->first()->id;

        foreach ($request->jawaban as $indikatorId => $jawaban) {
            JawabanIndikator::updateOrCreate(
                [
                    'indikator_id' => $indikatorId,
                    'periode_id' => $periodeId,
                ],
                [
                    'jawaban' => $jawaban,
                    'nilai' => $request->nilai[$indikatorId] ?? 0,
                    'persen' => $request->persen[$indikatorId] ?? 0,
                    'catatan' => $request->catatan[$indikatorId] ?? null,
                    'bukti' => $request->bukti[$indikatorId] ?? null,
                    'link' => $request->link[$indikatorId] ?? null,
                ],
            );
        }

        return redirect()
            ->route('manager-area.jawaban.preview', [
                'area' => $request->area_id,
                'kategori' => $request->kategori,
            ])

            ->with('success', 'Jawaban berhasil disimpan.');
    }

    public function preview($area, $kategori)
    {
        $periode = Periode::latest()->first();

        $jawabans = JawabanIndikator::with(['indikator', 'indikator.opsiJawaban'])
            ->whereHas('indikator', function ($q) use ($area, $kategori, $periode) {
                $q->where('area_id', $area)->where('kategori', $kategori)->where('periode_id', $periode->id);
            })
            ->get();

        return view('manager-area.jawaban.preview', [
            'jawabans' => $jawabans,
            'periode' => $periode,
            'kategori' => $kategori,
            'areaId' => $area,
            'currentKategori' => $kategori,
        ]);
    }
}
