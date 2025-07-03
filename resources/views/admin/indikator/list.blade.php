@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Data Indikator</h1>
        <a href="{{ route('indikator.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">+ Tambah Indikator</a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto p-4">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Kategori</th>
                    <th class="px-4 py-2">Area</th>
                    <th class="px-4 py-2">Sub Area</th>
                    <th class="px-4 py-2">Nama Indikator</th>
                    <th class="px-4 py-2">Pertanyaan</th>
                    <th class="px-4 py-2">Tipe Jawaban</th>
                    <th class="px-4 py-2 text-center">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($indikators as $indikator)
                <tr class="border-t">
                    
                    <td class="px-4 py-2 capitalize">{{ $indikator->kategori }}</td>
                    <td class="px-4 py-2">{{ $indikator->area->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $indikator->subArea->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $indikator->nama_indikator }}</td>
                    <td class="px-4 py-2">{{ $indikator->pertanyaan }}</td>
                    <td class="px-4 py-2">{{ $indikator->tipe_jawaban }}</td>
                    <td class="px-4 py-2 text-center">
                        @if ($indikator->status === 'published')
                            <span class="text-green-600 text-sm">Published</span>
                        @else
                            <span class="text-gray-600 text-sm">Draft</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-center flex justify-center gap-3 mt-2">
                        <a href="{{ route('indikator.edit', $indikator->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">Edit</a>

                        <form action="{{ route('indikator.destroy', $indikator->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus indikator ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>

                        @if ($indikator->status === 'draft')
                            <form action="{{ route('indikator.publish', $indikator->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded">
                                    Publish
                                </button>
                            </form>
                        @else
                            <form action="{{ route('indikator.unpublish', $indikator->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1 rounded">
                                    Unpublish
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada indikator.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
