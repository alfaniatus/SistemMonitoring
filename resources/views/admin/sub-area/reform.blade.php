@extends('layouts.app')

@section('title', 'Reform Area')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Halaman Reform Area Admin</h1>
        <p class="text-gray-600 mb-4">
            Ini adalah contoh konten untuk halaman "Reform Area" di panel admin.
            Anda bisa menambahkan berbagai informasi atau fungsionalitas terkait reform di sini.
        </p>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Detail Reformasi</h2>
            <ul class="list-disc list-inside text-gray-600">
                <li>Implementasi kebijakan baru.</li>
                <li>Peningkatan efisiensi proses kerja.</li>
                <li>Pengembangan sumber daya manusia.</li>
                <li>Evaluasi dampak reformasi.</li>
            </ul>
            <p class="mt-4 text-sm text-gray-500">
                Konten ini dapat disesuaikan dengan kebutuhan spesifik proyek Anda.
            </p>
        </div>

        <div class="mt-8">
            <a href="{{ route('admin.dashboard') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                Kembali ke Dashboard Admin
            </a>
        </div>
    </div>
@endsection

