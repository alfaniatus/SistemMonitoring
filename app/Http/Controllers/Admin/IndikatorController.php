<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Indikator;
use App\Models\Area;
use App\Models\SubArea;
use App\Models\OpsiJawaban;
use App\Models\Periode;


class IndikatorController extends Controller
{
    public function index()
    {
        $indikators = Indikator::with('area', 'subArea')->get();
        return view('admin.indikator.list', compact('indikators'));
    }

    public function create()
    {
        $areas = Area::with('subAreas')->get(); 
        $periodes = Periode::all();
        return view('admin.indikator.create', compact('areas', 'periodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'kategori' => 'required|in:reform,pemenuhan',
            'pertanyaan' => 'required',
            'nama_indikator' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'sub_area_id' => 'required|exists:sub_areas,id',
            'kategori' => 'required|in:reform,pemenuhan',
            'tipe_jawaban' => 'required|in:ya/tidak,abcde',
        ]);

        // Simpan indikator utama
        $indikator = Indikator::create([
            'periode_id' => $request->periode_id,
            'kategori' => $request->kategori,
            'pertanyaan' => $request->pertanyaan,
            'nama_indikator' => $request->nama_indikator,
            'area_id' => $request->area_id,
            'sub_area_id' => $request->sub_area_id,
            'kategori' => $request->kategori,
            'tipe_jawaban' => $request->tipe_jawaban,
            'bobot' => 0, // default sementara, karena pakai bobot per opsi
            'is_published' => false,
        ]);

        // TIPE YA/TIDAK
        if ($request->tipe_jawaban === 'ya/tidak') {
            $opsiYaTidak = [['opsi' => 'A', 'teks' => 'Ya', 'bobot' => 1.0], ['opsi' => 'B', 'teks' => 'Tidak', 'bobot' => 0.0]];

            foreach ($opsiYaTidak as $opsi) {
                OpsiJawaban::create([
                    'indikator_id' => $indikator->id,
                    'opsi' => $opsi['opsi'],
                    'teks' => $opsi['teks'],
                    'bobot' => $opsi['bobot'],
                ]);
            }
        }

        // TIPE ABCDE
        if ($request->tipe_jawaban === 'abcde') {
            if ($request->has('opsi_jawaban')) {
                foreach ($request->opsi_jawaban as $kode => $opsi) {
                    if (!empty($opsi['teks']) && isset($opsi['bobot'])) {
                        OpsiJawaban::create([
                            'indikator_id' => $indikator->id,
                            'opsi' => $kode, // PAKAI 'opsi' bukan 'kode'
                            'teks' => $opsi['teks'],
                            'bobot' => $opsi['bobot'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('indikator.index')->with('success', 'Data Indikator Berhasil Disimpan');
    }

    public function list()
    {
        $indikators = Indikator::with('area', 'subArea')->where('is_published', false)->orderBy('created_at', 'desc')->get();

        return view('admin.indikator.list', compact('indikators'));
    }

    public function edit($id)
    {
        $indikator = Indikator::with('opsiJawaban')->findOrFail($id);

        $areas = Area::with('subAreas')->get();
        $subAreas = SubArea::where('area_id', $indikator->area_id)->get();
        $tipeList = ['ya/tidak', 'abcde'];

        // Total bobot otomatis
        $totalBobot = 0;
        if ($indikator->tipe_jawaban === 'abcde') {
            $totalBobot = $indikator->opsiJawaban->sum('bobot');
        } elseif ($indikator->tipe_jawaban === 'ya/tidak') {
            $totalBobot = 1.0;
        }

        return view('admin.indikator.edit', compact('indikator', 'areas', 'subAreas', 'tipeList', 'totalBobot'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'nama_indikator' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'sub_area_id' => 'required|exists:sub_areas,id',
            'tipe_jawaban' => 'required|in:ya/tidak,abcde',
        ]);

        $indikator = Indikator::findOrFail($id);
        $indikator->update([
            'pertanyaan' => $request->pertanyaan,
            'nama_indikator' => $request->nama_indikator,
            'area_id' => $request->area_id,
            'sub_area_id' => $request->sub_area_id,
            'tipe_jawaban' => $request->tipe_jawaban,
        ]);

        // Hapus opsi jika ada yang ditandai
        if ($request->has('opsi_dihapus')) {
            OpsiJawaban::whereIn('id', $request->opsi_dihapus)->delete();
        }

        // Simpan/update opsi jawaban
        if ($request->has('opsi')) {
            foreach ($request->opsi as $data) {
                if (isset($data['id'])) {
                    OpsiJawaban::where('id', $data['id'])->update([
                        'opsi' => $data['opsi'],
                        'teks' => $data['teks'],
                        'bobot' => $data['bobot'],
                    ]);
                } else {
                    OpsiJawaban::create([
                        'indikator_id' => $indikator->id,
                        'opsi' => $data['opsi'],
                        'teks' => $data['teks'],
                        'bobot' => $data['bobot'],
                    ]);
                }
            }
        }

        return redirect()->route('indikator.index')->with('success', 'Data indikator berhasil diperbarui');
    }

    public function destroy($id)
    {
        Indikator::destroy($id);
        return redirect()->route('indikator.index')->with('success', 'Data Indikator Berhasil Dihapus');
    }
    public function copyIndikator(Request $request)
{
    $from = $request->from_periode_id;
    $to = $request->to_periode_id;

    $indikators = Indikator::where('periode_id', $from)->get();

    foreach ($indikators as $ind) {
        Indikator::create([
            'periode_id' => $to,
            'kategori' => $ind->kategori,
            'area_id' => $ind->area_id,
            'sub_area_id' => $ind->sub_area_id,
            'pertanyaan' => $ind->pertanyaan,
            'tipe_jawaban' => $ind->tipe_jawaban,
            'bobot' => $ind->bobot,
            'is_published' => false, // ⬅️ belum dipublish ulang
        ]);
    }

    return back()->with('success', 'Template berhasil disalin ke periode baru.');
}

}
