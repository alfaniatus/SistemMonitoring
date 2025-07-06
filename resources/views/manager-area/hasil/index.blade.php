@extends('layouts.manager')

@section('content')
<div class="max-w-full mx-auto px-4 py-6 text-sm">
    <h1 class="text-xl font-bold mb-4">Hasil Evaluasi</h1>

    <div class="overflow-x-auto bg-white shadow rounded-lg p-4">
        @if (session('success'))
    <p class="text-green-600 text-sm mb-3">
        {{ session('success') }}
    </p>
@endif

        <table class="min-w-full table-auto border text-left text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1 border">No</th>
                    <th class="px-2 py-1 border">Nama Indikator</th>
                    <th class="px-2 py-1 border">Pertanyaan</th>
                    <th class="px-2 py-1 border text-center">Jawaban</th>
                    <th class="px-2 py-1 border text-center">Nilai</th>
                    <th class="px-2 py-1 border text-center">%</th>
                    <th class="px-2 py-1 border text-center">Catatan</th>
                    <th class="px-2 py-1 border text-center">Bukti</th>
                    <th class="px-2 py-1 border text-center">Link</th>
                    <th class="px-2 py-1 border text-center">Status Validasi</th>
                    <th class="px-2 py-1 border">Catatan Admin</th>
                    <th class="px-2 py-1 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jawabans as $i => $jawaban)
                    <tr class="border-t hover:bg-gray-50 align-top">
                        <td class="px-2 py-1 border text-center">{{ $i + 1 }}</td>
                        <td class="px-2 py-1 border">{{ $jawaban->indikator->nama_indikator }}</td>
                        <td class="px-2 py-1 border">{{ $jawaban->indikator->pertanyaan }}</td>
                        <td class="px-2 py-1 border text-center">{{ $jawaban->jawaban }}</td>
                        <td class="px-2 py-1 border text-center">{{ number_format($jawaban->nilai, 2) }}</td>
                        <td class="px-2 py-1 border text-center">{{ number_format($jawaban->persen, 0) }}%</td>
                        <td class="px-2 py-1 border text-center">{{ $jawaban->catatan }}</td>
<td class="px-2 py-1 border text-center">{{ $jawaban->bukti }}</td>
<td class="px-2 py-1 border text-center">
    @if($jawaban->link)
        <a href="{{ $jawaban->link }}" target="_blank" class="text-blue-600 underline">Link</a>
    @else
        <span class="text-gray-400 italic">-</span>
    @endif
</td>

                        <td class="px-2 py-1 border text-center">
                            @if ($jawaban->status_validasi === 'ditolak')
                                <span class="text-red-600 font-bold">Ditolak</span>
                            @elseif ($jawaban->status_validasi === 'diterima')
                                <span class="text-green-600 font-semibold">Diterima</span>
                            @else
                                <span class="text-gray-600 italic">Pending</span>
                            @endif
                        </td>
                        <td class="px-2 py-1 border">
                            @if ($jawaban->status_validasi === 'ditolak')
                                <span class="text-red-600">{{ $jawaban->catatan_admin ?? '-' }}</span>
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>
                        <td class="px-2 py-1 border text-center space-x-1">
                           @if($jawaban->status_validasi === 'ditolak')
    <a href="{{ route('manager-area.hasil.edit', $jawaban->id) }}"
       class="mt-1 inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-3 py-1 rounded">
        Edit
    </a>
@endif


@if($jawaban->status_validasi === 'pending' && $jawaban->submit_ulang)
    <form action="{{ route('manager-area.hasil.submitUlang', $jawaban->id) }}" method="POST">
    @csrf
    <button type="submit" class= "text-sm bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
        Submit Ulang
    </button>
</form>
@endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-gray-500">
                            Belum ada jawaban yang dikirim atau divalidasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
