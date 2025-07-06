@extends('layouts.manager')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-6 text-sm">
        <h1 class="text-xl font-bold mb-4">Perbaiki Jawaban Ditolak</h1>

        <form action="{{ route('manager-area.hasil.update', $jawaban->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white p-6 rounded shadow border space-y-4">

                {{-- Indikator --}}
                <div>
                    <label class="font-semibold">Indikator:</label>
                    <input type="text" readonly class="border px-3 py-2 rounded w-full bg-none"
                        value="{{ $jawaban->indikator->nama_indikator }}">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="font-semibold">Kategori:</label>
                    <input type="text" readonly class="border px-3 py-2 rounded w-full bg-none"
                        value="{{ ucfirst($jawaban->indikator->kategori) }}">
                </div>

                {{-- Pertanyaan --}}
                <div>
                    <label class="font-semibold">Pertanyaan:</label>
                    <textarea readonly rows="3" class="border rounded px-3 py-2 mt-1 w-full bg-none">{{ $jawaban->indikator->pertanyaan }}</textarea>
                </div>
                {{-- Jawaban (pilihan bisa diubah) --}}
                <div>
                    <label for="jawaban" class="font-semibold">Pilih Jawaban:</label>
                    <select name="jawaban" id="jawaban" class="border px-3 py-2 rounded w-full">
                        @foreach ($jawaban->indikator->opsiJawaban as $opsi)
                            <option value="{{ $opsi->opsi }}" {{ $jawaban->jawaban === $opsi->opsi ? 'selected' : '' }}>
                                {{ $opsi->opsi }} - Bobot: {{ number_format($opsi->bobot, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Nilai dan Persen --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold">Nilai:</label>
                        <input type="text" readonly class="border px-3 py-2 rounded w-full bg-none"
                            value="{{ number_format($jawaban->nilai, 2) }}">
                    </div>
                    <div>
                        <label class="font-semibold">Persentase:</label>
                        <input type="text" readonly class="border px-3 py-2 rounded w-full bg-none"
                            value="{{ number_format($jawaban->persen, 0) }}%">
                    </div>
                </div>

                {{-- Catatan (boleh edit) --}}
                <div>
                    <label for="catatan" class="font-semibold">Catatan:</label>
                    <textarea name="catatan" id="catatan" rows="3" class="border rounded px-3 py-2 mt-1 w-full"
                        placeholder="Tambahkan penjelasan atau alasan perubahan">{{ old('catatan', $jawaban->catatan) }}</textarea>
                </div>

                {{-- Bukti (boleh edit) --}}
                <div>
                    <label for="bukti" class="font-semibold">Bukti:</label>
                    <input type="text" name="bukti" id="bukti" class="border rounded px-3 py-2 mt-1 w-full"
                        placeholder="Nama dokumen atau file" value="{{ old('bukti', $jawaban->bukti) }}">
                </div>

                {{-- Link (boleh edit) --}}
                <div>
                    <label for="link" class="font-semibold">Link Bukti (Google Drive, dll):</label>
                    <input type="url" name="link" id="link" class="border rounded px-3 py-2 mt-1 w-full"
                        placeholder="https://..." value="{{ old('link', $jawaban->link) }}">
                </div>

                {{-- Tombol --}}
                <div class="text-right pt-4">
                    <a href="{{ route('manager-area.hasil.index') }}"
                        class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm mr-2">Batal</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                        Simpan Perbaikan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
