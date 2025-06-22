<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tahun;

class IndikatorController extends Controller
{
 public function index()
{
    $indikators = Indikator::with('area', 'subArea')
        ->where('is_published', false)
        ->orderByDesc('created_at')
        ->get();

    return view('admin.indikator.index', compact('indikators'));
}
}
