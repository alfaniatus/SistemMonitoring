<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Indikator;
use App\Models\Periode;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    // Halaman template indikator
    public function template(Request $request)
    {
        $periodes = Periode::orderBy('tahun', 'desc')->get();
        $indikators = collect();
        $periode = null;
        $kategori = $request->kategori ?? '';

        if ($request->filled('periode_id')) {
            $request->validate([
                'periode_id' => 'exists:periodes,id',
                'kategori' => 'nullable|in:reform,pemenuhan',
            ]);

            $periode = Periode::findOrFail($request->periode_id);
            $query = Indikator::with(['area', 'subArea'])->where('periode_id', $request->periode_id);

            if ($kategori) {
                $query->where('kategori', $kategori);
            }

            $indikators = $query->orderBy('created_at', 'desc')->get();
        }

        return view('admin.indikator.template', compact('periodes', 'periode', 'kategori', 'indikators'));
    }

    // Menyalin indikator dari periode lama ke baru (dengan status draft)
    public function copyTemplate(Request $request)
    {
        $request->validate([
            'old_periode_id' => 'required|exists:periodes,id',
            'new_periode_id' => 'required|exists:periodes,id|different:old_periode_id',
        ]);

        $oldPeriodeId = $request->old_periode_id;
        $newPeriodeId = $request->new_periode_id;

        $indikators = Indikator::whereHas('periodes', function ($q) use ($oldPeriodeId) {
            $q->where('periode_id', $oldPeriodeId)->where('published', 1);
        })->get();

        DB::beginTransaction();
        try {
            foreach ($indikators as $indikator) {
                // Duplikat indikator
                $newIndikator = $indikator->replicate();
                $newIndikator->periode_id = $newPeriodeId;
                $newIndikator->status = 'draft';
                $newIndikator->save();

                // Duplikat opsi jawaban
                foreach ($indikator->opsiJawaban as $opsi) {
                    $newOpsi = $opsi->replicate();
                    $newOpsi->indikator_id = $newIndikator->id;
                    $newOpsi->save();
                }

                // Tidak perlu insert ke pivot dulu. Tunggu saat publish.
            }

            DB::commit();
            return redirect()->back()->with('success', 'Template berhasil disalin ke periode baru. Silakan publish.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyalin template: ' . $e->getMessage());
        }
    }

    // Publish indikator ke periode baru
   public function bulkPublish(Request $request)
{
    $request->validate([
        'periode_id' => 'required|exists:periodes,id',
        'indikator_ids' => 'required|array',
        'indikator_ids.*' => 'exists:indikators,id',
    ]);

    $periodeId = $request->periode_id;
    $indikatorIds = $request->indikator_ids;

    foreach ($indikatorIds as $indikatorId) {
        // ✅ Update status indikator
        Indikator::where('id', $indikatorId)->update(['status' => 'published']);

        // ✅ Tambah pivot indikator_periode
        DB::table('indikator_periode')->updateOrInsert(
            ['indikator_id' => $indikatorId, 'periode_id' => $periodeId],
            ['published' => true, 'updated_at' => now()]
        );
    }

    return back()->with('success', 'Beberapa indikator berhasil dipublish.');
}

}
