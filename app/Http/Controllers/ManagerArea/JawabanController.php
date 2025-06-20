<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JawabanController extends Controller
{
    public function index() {
    $areaId = auth()->user()->area_id;
    $indikators = Indikator::where('area_id', $areaId)->where('is_published', true)->get();
    return view('manager-area.indikator.index', compact('indikators'));
}

public function store(Request $request, $id) {
    Jawaban::updateOrCreate(
        ['indikator_id' => $id, 'user_id' => auth()->id()],
        [
            'jawaban' => $request->jawaban,
            'catatan' => $request->catatan,
            'link_bukti' => $request->link_bukti,
        ]
    );

    return back();
}

}
