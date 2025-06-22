@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Template Indikator</h1>

        {{-- Form Filter --}}
        <form action="{{ route('indikator.template') }}" method="GET"
            class="bg-white shadow p-4 rounded-lg mb-6 border border-gray-200">
            <div class="flex flex-col md:flex-row md:items-end gap-4">
                {{-- Periode --}}
                <div class="w-full md:w-1/3">
                    <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                    <select name="periode_id" id="periode_id" class="w-full rounded border border-gray-300 px-3 py-2 text-sm"
                        required>
                        <option value="">-- Pilih Periode --</option>
                        @foreach ($periodes as $p)
                            <option value="{{ $p->id }}" {{ request('periode_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }} ({{ $p->tahun }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kategori --}}
                <div class="w-full md:w-1/3">
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" id="kategori" class="w-full rounded border border-gray-300 px-3 py-2 text-sm">
                        <option value="" {{ request('kategori') == '' ? 'selected' : '' }}> Semua Kategori
                        </option>
                        <option value="pemenuhan" {{ request('kategori') == 'pemenuhan' ? 'selected' : '' }}>Pemenuhan
                        </option>
                        <option value="reform" {{ request('kategori') == 'reform' ? 'selected' : '' }}>Reform</option>
                    </select>

                </div>

                {{-- Tombol --}}
                <div class="md:mb-1">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded text-sm">
                        Lihat
                    </button>
                </div>
            </div>
        </form>

        {{-- Tabel --}}
        @if (request('periode_id'))
            <div class="bg-white shadow-md rounded-lg overflow-x-auto p-4">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-xl font-semibold">
                            Indikator {{ $kategori == '' ? 'Semua Kategori' : ucfirst($kategori) }} - {{ $periode->nama }}
                            ({{ $periode->tahun }})
                        </h2>
                    </div>
                    <div>
                        <a href="{{ route('indikator.create', ['periode_id' => $periode->id, 'kategori' => $kategori, 'from_template' => 1]) }}"
                            class="bg-green-600 text-white text-sm px-4 py-2 rounded mb-4 inline-block">+ Tambah
                            Indikator</a>
                    </div>
                </div>




                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Pertanyaan</th>
                            <th class="px-4 py-2">Kategori</th>
                            <th class="px-4 py-2">Area</th>
                            <th class="px-4 py-2">Sub Area</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($indikators as $i => $indikator)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $i + 1 }}</td>
                                <td class="px-4 py-2">{{ $indikator->pertanyaan }}</td>
                                <td class="px-4 py-2">{{ ucfirst($indikator->kategori) }}</td>
                                <td class="px-4 py-2">{{ $indikator->area->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $indikator->subArea->name ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">
                                    <form action="{{ route('indikator.toggle-publish', $indikator->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="text-xs px-2 py-1 rounded font-semibold 
            {{ $indikator->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $indikator->is_published ? 'Published' : 'Draft' }}
                                        </button>
                                    </form>
                                </td>

                                {{-- AKSI --}}
                                <td class="px-4 py-2 text-center">
                                    <div class="flex justify-center space-x-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('indikator.edit', $indikator->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">
                                            Edit
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('indikator.destroy', $indikator->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus indikator ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">Belum ada indikator.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
