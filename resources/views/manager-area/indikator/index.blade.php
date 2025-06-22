@extends('layouts.manager')

@section('content')
<div class="max-w-full mx-auto px-4 py-6">
    <h1 class="text-xl font-bold mb-4">Lembar Kerja Evaluasi - {{ $periode->nama }} ({{ $periode->tahun }})</h1>

    <form action="{{ route('manager-area.jawaban.store') }}" method="POST">
        @csrf

        <div class="overflow-x-auto bg-white shadow rounded-lg p-4">
            <table class="min-w-full table-auto text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-1">No</th>
                        <th class="px-2 py-1">Pertanyaan</th>
                        <th class="px-2 py-1">Kategori</th>
                        <th class="px-2 py-1">Area</th>
                        <th class="px-2 py-1">Sub Area</th>
                        <th class="px-2 py-1">Bobot</th>
                        <th class="px-2 py-1">Pilihan</th>
                        <th class="px-2 py-1">Jawaban</th>
                        <th class="px-2 py-1">Nilai</th>
                        <th class="px-2 py-1">%</th>
                        <th class="px-2 py-1">Catatan</th>
                        <th class="px-2 py-1">Bukti</th>
                        <th class="px-2 py-1">Link</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($indikators as $i => $indikator)
                        <tr class="border-t align-top">
                            <td class="px-2 py-1">{{ $i + 1 }}</td>
                            <td class="px-2 py-1">{{ $indikator->pertanyaan }}</td>
                            <td class="px-2 py-1">{{ ucfirst($indikator->kategori) }}</td>
                            <td class="px-2 py-1">{{ $indikator->area->name ?? '-' }}</td>
                            <td class="px-2 py-1">{{ $indikator->subArea->name ?? '-' }}</td>
                            <td class="px-2 py-1 text-center">{{ number_format($indikator->bobot, 2) }}</td>
                            <td class="px-2 py-1">
                                @foreach ($indikator->opsiJawaban as $opsi)
                                    <div>{{ $opsi->label }}. {{ $opsi->opsi }} ({{ number_format($opsi->bobot, 2) }})</div>
                                @endforeach
                            </td>
                            <td class="px-2 py-1">
                                @if ($indikator->tipe_jawaban === 'ya_tidak')
                                    <select name="jawaban[{{ $indikator->id }}]" class="w-full border rounded px-2 py-1 text-sm">
                                        <option value="">-- Pilih --</option>
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                @elseif ($indikator->tipe_jawaban === 'abcde')
                                    <select name="jawaban[{{ $indikator->id }}]" class="w-full border rounded px-2 py-1 text-sm">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($indikator->opsiJawaban as $opsi)
                                            <option value="{{ $opsi->label }}">{{ $opsi->label }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td class="px-2 py-1">
                                <input type="text" name="nilai[{{ $indikator->id }}]" class="w-16 border rounded px-2 py-1 text-sm" readonly>
                            </td>
                            <td class="px-2 py-1">
                                <input type="text" name="persen[{{ $indikator->id }}]" class="w-16 border rounded px-2 py-1 text-sm" readonly>
                            </td>
                            <td class="px-2 py-1">
                                <textarea name="catatan[{{ $indikator->id }}]" rows="2" class="w-48 border rounded px-2 py-1 text-sm"></textarea>
                            </td>
                            <td class="px-2 py-1">
                                <input type="text" name="bukti[{{ $indikator->id }}]" class="w-48 border rounded px-2 py-1 text-sm">
                            </td>
                            <td class="px-2 py-1">
                                <input type="url" name="link[{{ $indikator->id }}]" class="w-48 border rounded px-2 py-1 text-sm">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-right">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded text-sm">
                Simpan Jawaban
            </button>
        </div>
    </form>
</div>
@endsection
