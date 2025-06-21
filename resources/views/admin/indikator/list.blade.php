@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded shadow text-sm">
    <h2 class="text-xl font-bold mb-4">Daftar Indikator Belum Dipublish</h2>

    @if (session('success'))
        <div class="mb-4 text-red-400">{{ session('success') }}</div>
    @endif

    <a href="{{ route('indikator.create') }}" class=" bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Indikator</a>

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Area</th>
                <th class="border px-4 py-2">Sub Area</th>
                <th class="border px-4 py-2">Kategori</th>
                <th class="border px-4 py-2">Nama Indikator</th>
                <th class="border px-4 py-2">Pertanyaan</th>
                <th class="border px-4 py-2">Tipe Jawaban</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($indikators as $indikator)
                <tr>
                    <td class="border px-4 py-2">{{ $indikator->area->name }}</td>
                    <td class="border px-4 py-2">{{ $indikator->subArea->name }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($indikator->kategori) }}</td>
                    <td class="border px-4 py-2">{{ $indikator->nama_indikator }}</td>
                    <td class="border px-4 py-2">{{ $indikator->pertanyaan }}</td>
                    <td class="border px-4 py-2">{{ strtoupper($indikator->tipe_jawaban) }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('indikator.edit', $indikator->id) }}" class="text-blue-600 hover:underline">Edit</a> |
                        <form action="{{ route('indikator.destroy', $indikator->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
