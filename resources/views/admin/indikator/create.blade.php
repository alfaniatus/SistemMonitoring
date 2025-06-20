@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-sm">
    <h2 class="text-xl font-bold mb-4">Tambah Indikator</h2>

    <form action="{{ route('indikator.store') }}" method="POST">
        @csrf

        {{-- AREA --}}
        <div class="mb-4">
            <label for="area_id" class="block font-semibold">Area</label>
            <select name="area_id" id="area_id" class="w-full border border-gray-300 rounded p-2">
                <option value="">-- Pilih Area --</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" data-subareas='@json($area->subAreas)'>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- SUB AREA --}}
        <div class="mb-4">
            <label for="sub_area_id" class="block font-semibold">Sub Area</label>
            <select name="sub_area_id" id="sub_area_id" class="w-full border border-gray-300 rounded p-2">
                <option value="">-- Pilih Sub Area --</option>
            </select>
        </div>
        
{{-- NAMA INDIKATOR --}}
<div class="mb-4">
    <label for="nama_indikator" class="block font-semibold">Nama Indikator</label>
    <input type="text" name="nama_indikator" id="nama_indikator" class="w-full border border-gray-300 rounded p-2">
</div>

        {{-- PERTANYAAN --}}
        <div class="mb-4">
            <label for="pertanyaan" class="block font-semibold">Pertanyaan</label>
            <textarea name="pertanyaan" id="pertanyaan" rows="3" class="w-full border border-gray-300 rounded p-2"></textarea>
        </div>

        {{-- TIPE JAWABAN --}}
        <div class="mb-4">
            <label for="tipe_jawaban" class="block font-semibold">Tipe Jawaban</label>
            <select name="tipe_jawaban" id="tipe_jawaban" class="w-full border border-gray-300 rounded p-2">
                <option value="">-- Pilih Tipe Jawaban --</option>
                <option value="ya/tidak">Ya / Tidak</option>
                <option value="abcde">A - E</option>
            </select>
        </div>

        {{-- OPSI JAWABAN DINAMIS --}}
        <div id="opsi-container" class="mb-4 hidden">
            <label class="block font-semibold">Opsi Jawaban</label>
            <div id="opsi-wrapper"></div>
            <button type="button" id="tambah-opsi" class="mt-2 bg-gray-200 px-3 py-1 rounded">+ Tambah Opsi</button>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const areaSelect = document.getElementById('area_id');
    const subAreaSelect = document.getElementById('sub_area_id');

    areaSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const subAreas = JSON.parse(selected.getAttribute('data-subareas') || '[]');
        subAreaSelect.innerHTML = '<option value="">-- Pilih Sub Area --</option>';
        subAreas.forEach(sub => {
            const option = document.createElement('option');
            option.value = sub.id;
            option.text = sub.name;
            subAreaSelect.appendChild(option);
        });
    });

    const tipeJawaban = document.getElementById('tipe_jawaban');
    const opsiContainer = document.getElementById('opsi-container');
    const opsiWrapper = document.getElementById('opsi-wrapper');
    const tambahOpsiBtn = document.getElementById('tambah-opsi');
    let kodeIndex = 0;
    const kodeList = ['A', 'B', 'C', 'D', 'E'];

    tipeJawaban.addEventListener('change', function () {
        if (this.value === 'abcde') {
            opsiContainer.classList.remove('hidden');
        } else {
            opsiContainer.classList.add('hidden');
            opsiWrapper.innerHTML = '';
            kodeIndex = 0;
        }
    });

    tambahOpsiBtn.addEventListener('click', function () {
        if (kodeIndex >= kodeList.length) return;
        const kode = kodeList[kodeIndex++];

        const field = `
            <div class="mb-2">
                <label class="block font-semibold">${kode}</label>
                <input type="hidden" name="opsi_jawaban[${kode}][kode]" value="${kode}">
                <input type="text" name="opsi_jawaban[${kode}][teks]" class="w-full border rounded p-1 mb-1" placeholder="Teks jawaban ${kode}">
                <input type="number" step="0.01" name="opsi_jawaban[${kode}][bobot]" class="w-full border rounded p-1" placeholder="Bobot jawaban ${kode}">
            </div>
        `;
        opsiWrapper.insertAdjacentHTML('beforeend', field);
    });
});
</script>
@endsection
