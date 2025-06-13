@extends('santri.layouts.app')

@section('title', 'About Us')

@section('content')
    <div class="px-8 py-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-6 text-center">About</h1>
        <p class="mt-4 text-lg text-gray-600 leading-relaxed mb-12 text-center">
            Aplikasi ini dibangun untuk mengatasi berbagai tantangan dalam pengelolaan modul pembelajaran di Pondok IT.
            Berikut adalah beberapa permasalahan utama yang ingin saya selesaikan:
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            {{-- Problem 1: Sistem Pengelolaan yang Tidak Terstruktur --}}
            <div class="bg-white rounded-lg shadow-lg p-6 text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div class="text-indigo-600 mb-4">
                    <i class="fas fa-folder-open fa-3x"></i> {{-- Updated icon --}}
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Pengelolaan Tidak Terstruktur</h3>
                <p class="text-gray-600">Modul pembelajaran tersebar dan sulit diorganisir, menghambat akses dan efisiensi.</p>
            </div>

            {{-- Problem 2: Kesulitan dalam Melakukan Perubahan --}}
            <div class="bg-white rounded-lg shadow-lg p-6 text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div class="text-green-600 mb-4">
                    <i class="fas fa-sync-alt fa-3x"></i> {{-- Updated icon --}}
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Proses Pembaruan Rumit</h3>
                <p class="text-gray-600">Revisi materi membutuhkan waktu lama dan proses yang berbelit-belit.</p>
            </div>

            {{-- Problem 3: Kurangnya Koordinasi Antar Pengajar --}}
            <div class="bg-white rounded-lg shadow-lg p-6 text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div class="text-purple-600 mb-4">
                    <i class="fas fa-handshake fa-3x"></i> {{-- Updated icon --}}
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Koordinasi Kurang Optimal</h3>
                <p class="text-gray-600">Tidak ada platform terpusat untuk kolaborasi antar Mentor dalam penyusunan materi.</p>
            </div>

            {{-- Problem 4: Akses Terbatas untuk Santri --}}
            <div class="bg-white rounded-lg shadow-lg p-6 text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div class="text-red-600 mb-4">
                    <i class="fas fa-user-lock fa-3x"></i> {{-- Updated icon --}}
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Akses Santri Terbatas</h3>
                <p class="text-gray-600">Santri kesulitan mendapatkan akses ke materi pembelajaran terbaru dan terorganisir.</p>
            </div>
        </div>
    </div>
@endsection
