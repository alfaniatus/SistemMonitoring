<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Indikator;
use App\Models\Area;
use App\Models\SubArea;
use App\Models\OpsiJawaban;

class IndikatorController extends Controller
{
    public function index()
    {
        $indikators = Indikator::with('area', 'subArea')->get();
        return view('admin.indikator.list', compact('indikators'));
    }

    public function create()
    {
        $areas = Area::with('subAreas')->get(); // include subAreas
        return view('admin.indikator.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'nama_indikator' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'sub_area_id' => 'required|exists:sub_areas,id',
            'tipe_jawaban' => 'required|in:ya/tidak,abcde',
        ]);

        // Simpan indikator utama
        $indikator = Indikator::create([
            'pertanyaan' => $request->pertanyaan,
            'nama_indikator' => $request->nama_indikator, 
            'area_id' => $request->area_id,
            'sub_area_id' => $request->sub_area_id,
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
            'tipe_jawaban' => 'required|in:ya/tidak,abcde,esai',
            'bobot' => 'required|numeric',
        ]);

        $indikator = Indikator::findOrFail($id);
        $indikator->update($request->all());

        return redirect()->route('indikator.index')->with('success', 'Data Indikator Berhasil Diupdate');
    }

    public function destroy($id)
    {
        Indikator::destroy($id);
        return redirect()->route('indikator.index')->with('success', 'Data Indikator Berhasil Dihapus');
    }
}
