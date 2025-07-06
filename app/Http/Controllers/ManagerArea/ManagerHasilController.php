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
        $validated = $request->validate(
            [
                'jawaban' => 'required|array',
                'bukti' => 'required|array',
                'link' => 'nullable|array',
                'nilai' => 'nullable|array',
                'persen' => 'nullable|array',
                'catatan' => 'nullable|array',
            ],
            [
                'bukti.required' => 'Setiap indikator wajib diisi bukti.',
            ],
        );

        $areaId = $request->input('area_id');
        $kategori = $request->input('kategori');
        $periode = Periode::orderByDesc('tahun')->first();
        $userId = auth()->id();

        foreach ($validated['jawaban'] as $indikatorId => $jawab) {
            JawabanIndikator::updateOrCreate(
                [
                    'indikator_id' => $indikatorId,
                    'periode_id' => $periode->id,
                    'user_id' => $userId,
                ],
                [
                    'jawaban' => $jawab,
                    'nilai' => $validated['nilai'][$indikatorId] ?? 0,
                    'persen' => $validated['persen'][$indikatorId] ?? 0,
                    'catatan' => $validated['catatan'][$indikatorId] ?? null,
                    'bukti' => $validated['bukti'][$indikatorId] ?? '-',
                    'link' => $validated['link'][$indikatorId] ?? null,
                    'user_id' => $userId,

                ]
            );
        }

        return redirect()
            ->route('manager-area.jawaban.preview', [
                'area' => $areaId,
                'kategori' => $kategori,
            ])
            ->with('success', 'Jawaban berhasil disimpan.');
    }

    public function preview($area, $kategori)
    {
        $periode = Periode::orderByDesc('tahun')->first();
        $userId = auth()->id();

        $jawabans = JawabanIndikator::with('indikator')
            ->where('periode_id', $periode->id)
            ->where('user_id', $userId)
            ->whereHas('indikator', function ($query) use ($area, $kategori) {
                $query->where('area_id', $area)
                      ->where('kategori', $kategori);
            })
            ->get();

        return view('manager-area.jawaban.preview', [
            'jawabans' => $jawabans,
            'periode' => $periode,
            'areaId' => $area,
            'currentKategori' => $kategori,
        ]);
    }

    public function submitJawaban($area, $kategori, Request $request)
    {
        $userId = auth()->id();
        $periodeId = $request->input('periode_id');

        JawabanIndikator::where('user_id', $userId)
            ->where('periode_id', $periodeId)
            ->whereHas('indikator', function ($q) use ($area, $kategori) {
                $q->where('area_id', $area)
                  ->where('kategori', $kategori);
            })
            ->update(['is_submitted' => true]);

        return redirect()
            ->route('manager-area.indikator.index', [
                'area' => $area,
                'kategori' => $kategori,
            ])
            ->with('success', 'Jawaban berhasil dikirim untuk divalidasi admin.');
    }
}