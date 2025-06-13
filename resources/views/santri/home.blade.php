@extends('santri.layouts.app')

@section('title', 'Home - Modul Pembelajaran Santri Pondok IT')

@section('content')
    <div class="container mx-auto mt-10 text-center">
        <h1 class="text-5xl font-bold text-gray-800">Modul Pembelajaran Santri Pondok IT</h1>
        <p class="mt-4 text-xl text-gray-600">Platform untuk membuat, mengelola, membaca, dan mengunduh modul pembelajaran.</p>
    </div>

    {{-- Fitur Unggulan Section --}}
    <div class="container mx-auto mt-16 px-4">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-12">Fitur Unggulan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Feature 1: Modul Interaktif --}}
            <div class="bg-white rounded-lg shadow-lg p-6 text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div class="text-indigo-600 mb-4">
                    <i class="fas fa-box-archive fa-3x"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Penyimpanan Terpusat</h3>
                <p class="text-gray-600">Semua modul tersimpan rapih di satu tempat, tidak bercampur dengan pesan lain seperti di WhatsApp.</p>
            </div>

            {{-- Feature 2: Akses Offline --}}
            <div class="bg-white rounded-lg shadow-lg p-6 text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div class="text-green-600 mb-4">
                    <i class="fas fa-download fa-3x"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Akses Offline</h3>
                <p class="text-gray-600">Unduh modul dan dapatkan file pdf untuk dibaca kapan saja, di mana saja, tanpa koneksi internet.</p>
            </div>

            {{-- Feature 3: Tampilan User-Friendly --}}
            <div class="bg-white rounded-lg shadow-lg p-6 text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div class="text-red-600 mb-4">
                    <i class="fas fa-lightbulb fa-3x"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Tampilan Mudah Dipahami</h3>
                <p class="text-gray-600">Desain antarmuka yang sederhana dan intuitif, membuat belajar lebih menyenangkan.</p>
            </div>
        </div>
    </div>
@endsection
