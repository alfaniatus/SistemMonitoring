@extends('layouts.manager')

@section('content')
    <div class="max-w-full mx-auto px-4 py-6">
        <h1 class="text-xl font-bold mb-4">
            Lembar Kerja Evaluasi - {{ $periode->nama }} ({{ $periode->tahun }})
        </h1>

        <form action="{{ route('manager-area.jawaban.store') }}" method="POST">
            @csrf
            <input type="hidden" name="area_id" value="{{ $areaId }}">
            <input type="hidden" name="kategori" value="{{ $kategori }}">


            <div class="overflow-x-auto bg-white shadow rounded-lg p-4">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-2 py-1">No</th>
                            <th class="px-2 py-1">Pertanyaan</th>
                            <th class="px-2 py-1">Bobot</th>
                            <th class="px-2 py-1">Pilihan</th>
                            {{-- <th class="px-2 py-1">Tipe</th> --}}
                            <th class="px-2 py-1">Jawaban</th>
                            <th class="px-2 py-1">Nilai</th>
                            <th class="px-2 py-1">%</th>
                            <th class="px-2 py-1">Catatan</th>
                            <th class="px-2 py-1">Bukti</th>
                            <th class="px-2 py-1">Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($indikators as $i => $indikator)
                            <tr class="border-t align-top">
                                <td class="px-2 py-1">{{ $i + 1 }}</td>
                                <td class="px-2 py-1">{{ $indikator->pertanyaan }}</td>
                                <td class="px-2 py-1 text-center">{{ number_format($indikator->bobot, 2) }}</td>
                                <td class="px-2 py-1">
                                    @foreach ($indikator->opsiJawaban as $opsi)
                                        <div>{{ $opsi->opsi }}. {{ $opsi->teks }}
                                            ({{ number_format($opsi->bobot, 2) }})
                                        </div>
                                    @endforeach
                                </td>
                                {{-- <td class="px-2 py-1 bg-yellow-100">{{ $indikator->tipe_jawaban }}</td> --}}
                                <td class="px-2 py-1">
                                    @if ($indikator->tipe_jawaban === 'ya/tidak')
                                        <select name="jawaban[{{ $indikator->id }}]"
                                            class="w-full border rounded px-2 py-1 text-sm jawaban-select"
                                            data-id="{{ $indikator->id }}" data-jenis="ya_tidak">
                                            <option value="">-- Pilih --</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    @elseif ($indikator->tipe_jawaban === 'abcde')
                                        <select name="jawaban[{{ $indikator->id }}]"
                                            class="w-full border rounded px-2 py-1 text-sm jawaban-select"
                                            data-id="{{ $indikator->id }}" data-jenis="abcde">
                                            <option value="">-- Pilih --</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                        </select>
                                    @endif

                                </td>
                                <td class="px-2 py-1">
                                    <input type="text" name="nilai[{{ $indikator->id }}]"
                                        class="w-16 border rounded px-2 py-1 text-sm" readonly>
                                </td>
                                <td class="px-2 py-1">
                                    <input type="text" name="persen[{{ $indikator->id }}]"
                                        class="w-16 border rounded px-2 py-1 text-sm" readonly>
                                </td>
                                <td class="px-2 py-1">
                                    <textarea name="catatan[{{ $indikator->id }}]" rows="2" class="w-48 border rounded px-2 py-1 text-sm"></textarea>
                                </td>
                                <td class="px-2 py-1">
                                    <input type="text" name="bukti[{{ $indikator->id }}]"
                                        class="w-48 border rounded px-2 py-1 text-sm">
                                </td>
                                <td class="px-2 py-1">
                                    <div>
                                        <input type="url" name="link[{{ $indikator->id }}]"
                                            class="link-input w-48 border rounded px-2 py-1 text-sm mb-1"
                                            data-id="{{ $indikator->id }}" placeholder="https://drive.google.com/..." />

                                        <div class="text-xs">
                                            <a href="#" target="_blank" id="preview-link-{{ $indikator->id }}"
                                                class="text-blue-600 hover:underline hidden">
                                                🔗 Lihat Dokumen
                                            </a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-red-500 py-4">
                                    Tidak ada indikator ditemukan.
                                </td>
                            </tr>
                        @endforelse
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto Nilai untuk ya/tidak
            const selects = document.querySelectorAll('.jawaban-select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    const indikatorId = this.dataset.id;
                    const tipe = this.dataset.jenis;
                    const nilaiInput = document.querySelector(
                        `input[name="nilai[${indikatorId}]"]`);
                    if (tipe === 'ya_tidak') {
                        if (this.value === 'Ya') {
                            nilaiInput.value = '1.00';
                        } else if (this.value === 'Tidak') {
                            nilaiInput.value = '0.00';
                        } else {
                            nilaiInput.value = '';
                        }
                    }
                    else if (tipe === 'abcde') {
                        if (this.value === 'A') {
                            nilaiInput.value = '1.00';
                        } else if (this.value === 'B') {
                            nilaiInput.value = '0.75';
                        } else if (this.value === 'C') {
                            nilaiInput.value = '0.50';
                        } else if (this.value === 'D') {
                            nilaiInput.value = '0.25';
                        } else if (this.value === 'E') {
                            nilaiInput.value = '0.00';
                        }
                    }
                });

            });

            // Auto preview link
            const linkInputs = document.querySelectorAll('.link-input');
            linkInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const id = this.dataset.id;
                    const preview = document.getElementById(`preview-link-${id}`);
                    if (this.value.startsWith('http')) {
                        preview.href = this.value;
                        preview.classList.remove('hidden');
                    } else {
                        preview.href = '#';
                        preview.classList.add('hidden');
                    }
                });
            });
        });
    </script>


@endsection
