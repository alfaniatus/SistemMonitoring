@extends('layouts.app')


@section('content')
    <div class="max-w-5xl mx-auto p-6 bg-white rounded shadow text-sm">
        <h2 class="text-xl font-semibold mb-6 text-[#0E4A64]">Edit Indikator</h2>

        <form method="POST" action="{{ route('indikator.update', $indikator->id) }}"
            data-opsicount="{{ count($indikator->opsiJawaban) }}" data-subarea-id="{{ $indikator->sub_area_id }}">
            @csrf
            @method('PUT')

            @if (request('from') === 'template')
                <input type="hidden" name="from" value="template">
                <input type="hidden" name="periode_id" value="{{ request('periode_id') }}">
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif

            <div class="space-y-4">

               

                {{-- Area --}}
                <div>
                    <label class="block font-medium">Area</label>
                    <select name="area_id" id="area_id" class="w-full border px-3 py-2 rounded" required>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" data-subareas='@json($area->subAreas)'
                                {{ $indikator->area_id == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sub Area --}}
                <div>
                    <label class="block font-medium">Sub Area</label>
                    <select name="sub_area_id" id="sub_area_id" class="w-full border px-3 py-2 rounded" required>
                        @foreach ($subAreas as $sub)
                            <option value="{{ $sub->id }}" {{ $indikator->sub_area_id == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Indikator --}}
                <div>
                    <label class="block font-medium">Nama Indikator</label>
                    <input type="text" name="nama_indikator"
                        value="{{ old('nama_indikator', $indikator->nama_indikator) }}"
                        class="w-full border px-3 py-2 rounded" required>
                </div>

                 {{-- Pertanyaan --}}
                <div>
                    <label class="block font-medium">Pertanyaan</label>
                    <textarea name="pertanyaan" required class="w-full border px-3 py-2 rounded">{{ old('pertanyaan', $indikator->pertanyaan) }}</textarea>
                </div>

                {{-- Tipe Jawaban --}}
                <div>
                    <label class="block font-medium">Tipe Jawaban</label>
                    <select name="tipe_jawaban" id="tipe_jawaban" class="w-full border px-3 py-2 rounded" required>
                        @foreach ($tipeList as $tipe)
                            <option value="{{ $tipe }}" {{ $indikator->tipe_jawaban === $tipe ? 'selected' : '' }}>
                                {{ strtoupper($tipe) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Opsi Jawaban --}}
                <div id="opsi_abcde"
                    class="grid grid-cols-1 md:grid-cols-2 gap-4 {{ $indikator->tipe_jawaban !== 'abcde' ? 'hidden' : '' }}">
                    @php $abjad = range('A', 'Z'); @endphp
                    @foreach ($indikator->opsiJawaban as $i => $opsi)
                        <div class="bg-gray-50 p-4 rounded shadow-sm">
                            <label class="block font-medium">Opsi {{ $abjad[$i] ?? '' }}</label>
                            <input type="text" name="opsi[{{ $i }}][teks]" value="{{ $opsi->teks }}"
                                class="w-full border rounded px-3 py-2 mb-1" required>

                            <label class="block font-medium">Bobot</label>
                            <input type="number" step="0.01" min="0" max="1"
                                name="opsi[{{ $i }}][bobot]" value="{{ $opsi->bobot }}"
                                class="w-full border rounded px-3 py-2" required>

                            <input type="hidden" name="opsi[{{ $i }}][id]" value="{{ $opsi->id }}">
                            <input type="hidden" name="opsi[{{ $i }}][opsi]" value="{{ $abjad[$i] ?? '' }}">
                        </div>
                    @endforeach
                </div>

                {{-- Tambah Opsi Baru --}}
                <div id="tambah_opsi_wrapper" class="{{ $indikator->tipe_jawaban !== 'abcde' ? 'hidden' : '' }}">
                    <button type="button" id="btn_tambah_opsi"
                        class="mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        + Tambah Opsi
                    </button>
                </div>

                {{-- Bobot Total --}}
                <div>
                    <label class="block font-medium mt-4">Bobot Total (otomatis)</label>
                    <input type="text" id="bobot_total" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>

                {{-- Tombol --}}
                <div>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white  px-4 py-2 rounded">
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>
    </div>

    <script src="{{ asset('js/edit-indikator.js') }}"></script>
@endsection
