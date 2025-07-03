@extends('layouts.manager')

@section('content')
    <div class="max-w-full mx-auto px-4 py-6">
        <h1 class="text-xl font-bold mb-4">
            Lembar Kerja Evaluasi - {{ $periode->nama }} ({{ $periode->tahun }})
        </h1>

        <div class="overflow-x-auto bg-white shadow rounded-lg p-4">
            <table class="min-w-full table-auto text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-1">No</th>
                        <th class="px-2 py-1">Pertanyaan</th>
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
                    @forelse ($jawabans as $i => $jawaban)
                        <tr class="border-t align-top">
                            <td class="px-2 py-1">{{ $i + 1 }}</td>
                            <td class="px-2 py-1">{{ $jawaban->indikator->pertanyaan }}</td>
                            <td class="px-2 py-1 text-center">{{ number_format($jawaban->indikator->bobot, 2) }}</td>
                            <td class="px-2 py-1">
                                @foreach ($jawaban->indikator->opsiJawaban as $opsi)
                                    <div>{{ $opsi->opsi }}. {{ $opsi->teks }} ({{ number_format($opsi->bobot, 2) }})
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-2 py-1">{{ $jawaban->jawaban ?? '-' }}</td>
                            <td class="px-2 py-1">{{ number_format($jawaban->nilai ?? 0, 2) }}</td>
                            <td class="px-2 py-1">{{ number_format($jawaban->persen ?? 0, 2) }}</td>
                            <td class="px-2 py-1">{{ $jawaban->catatan ?? '-' }}</td>
                            <td class="px-2 py-1">{{ $jawaban->bukti ?? '-' }}</td>
                            <td class="px-2 py-1">
                                @if ($jawaban->link)
                                    <a href="{{ $jawaban->link }}" target="_blank" class="text-blue-600 hover:underline">🔗
                                        Lihat</a>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-red-500 py-4">Belum ada jawaban yang diisi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('manager-area.indikator.index', [
                'area' => $areaId,
                'kategori' => $kategori,
                'periode' => $periode->id,
            ]) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm">
                ← Kembali
            </a>
        </div>

    </div>
@endsection
