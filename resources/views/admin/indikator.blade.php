@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-md px-3 py-4 shadow">
        <form action="#" method="GET" class="flex justify-end gap-4 items-center">
            <div>
                <select name="tahun" class="border px-4 py-2 rounded focus:outline-none">
                    @foreach ($tahunList as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-[#146082] text-white px-4 py-2 rounded hover:bg-[#104b66] text-sm font-medium">
                SET
            </button>
        </form>
    </div>
      <div class="bg-white rounded-md p-6 min-h-[300px] shadow mt-6">

      </div>
      @section('content')
    <h1 class="text-xl font-bold mb-4">Indikator - Admin</h1>

    <a href="{{ route('admin.indikator') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Indikator</a>

    <table class="w-full table-auto border mt-4">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Nama Indikator</th>
                <th class="p-2">Area</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataIndikator as $indikator)
                <tr class="border-t">
                    <td class="p-2">{{ $indikator->nama }}</td>
                    <td class="p-2">Area {{ $indikator->area_id }}</td>
                    <td class="p-2">
                        <a href="{{ route('admin.indikator.edit', $indikator->id) }}" class="text-blue-600">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@endsection