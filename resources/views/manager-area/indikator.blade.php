@extends('layouts.manager')

@section('content')
    <h1 class="text-xl font-bold mb-4">Indikator - Manager Area {{ $areaId }}</h1>

    <table class="w-full table-auto border mt-4">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Nama Indikator</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataIndikator as $indikator)
                <tr class="border-t">
                    <td class="p-2">{{ $indikator->nama }}</td>
                    <td class="p-2">
                        <a href="{{ route('manager-area.indikator.isi', $indikator->id) }}" class="text-green-600">Isi Jawaban</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection