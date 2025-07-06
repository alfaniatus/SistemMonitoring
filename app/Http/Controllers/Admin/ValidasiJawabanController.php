<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JawabanIndikator;
use App\Models\Periode;
use App\Models\Area;

class ValidasiJawabanController extends Controller
{
    public function index(Request $request)
    {
        $periodeId = $request->input('periode_id');
        $areaId = $request->input('area_id');
        $kategori = $request->input('kategori');

        $jawabans = JawabanIndikator::with([
                'indikator.opsiJawaban',
                'indikator.area',
                'indikator.subArea'
            ])
            ->where('is_submitted', true)
            ->when($periodeId, function ($query) use ($periodeId) {
                $query->whereHas('indikator.periodes', function ($periodeQuery) use ($periodeId) {
                    $periodeQuery->where('periodes.id', $periodeId);
                });
            })
            ->when($areaId, function ($query) use ($areaId) {
                $query->whereHas('indikator', function ($q) use ($areaId) {
                    $q->where('area_id', $areaId);
                });
            })
            ->when($kategori, function ($query) use ($kategori) {
                $query->whereHas('indikator', function ($q) use ($kategori) {
                    $q->where('kategori', $kategori);
                });
            })
            ->get();

        $periodes = Periode::orderByDesc('tahun')->get();
        $areas = Area::all();
        $kategoris = ['pemenuhan', 'reform'];

        return view('admin.validasi.index', compact('jawabans', 'periodes', 'areas', 'kategoris'));
    }

    public function simpan(Request $request)
    {
        $data = $request->input('validasi', []);

        foreach ($data as $jawabanId => $item) {
            $jawaban = JawabanIndikator::find($jawabanId);
            if ($jawaban) {
                $jawaban->status_validasi = $item['status'] ?? 'pending';
                $jawaban->catatan_admin = $item['catatan'] ?? null;
                $jawaban->save();
            }
        }

        return redirect()->route('admin.validasi.index')->with('success', 'semua data berhasil divalidasi.');
    }
}
