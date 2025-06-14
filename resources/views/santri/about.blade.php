@extends('santri.layouts.app')

@section('title', 'About Us')

@section('content')
    {{-- Header Section --}}
    <div class="max-w-5xl mx-auto mb-12">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Tentang Aplikasi</h1>
            <div class="h-1 w-24 bg-blue-600 mx-auto mb-6 rounded-full"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Aplikasi ini dibangun untuk mengatasi berbagai tantangan dalam pengelolaan modul pembelajaran di Pondok IT.
                Berikut adalah beberapa permasalahan utama yang ingin kami selesaikan:
            </p>
        </div>
    </div>

    {{-- Problems Grid --}}
    <div class="max-w-6xl mx-auto mb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            {{-- Problem 1 --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <div class="bg-white bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Pengelolaan Tidak Terstruktur</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">
                        Modul pembelajaran sebelumnya tersebar di berbagai tempat dan sulit diorganisir dengan baik. Hal ini membuat akses terhadap materi menjadi tidak efisien, meningkatkan kemungkinan kehilangan data, dan memperlambat proses belajar mengajar.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                        <span>Solusi: Repositori terpusat</span>
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Problem 2 --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <div class="bg-white bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Proses Pembaruan Rumit</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">
                        Revisi materi pembelajaran membutuhkan waktu lama dan proses yang berbelit-belit. Mentor harus melalui beberapa tahapan yang tidak efisien untuk memperbarui materi, yang berakibat pada lambatnya pembaruan konten untuk mengikuti perkembangan teknologi.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-green-600 font-medium">
                        <span>Solusi: Sistem pembaruan langsung</span>
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Problem 3 --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <div class="bg-white bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Koordinasi Kurang Optimal</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">
                        Kurangnya platform terpusat menyebabkan koordinasi antar Mentor dalam penyusunan materi menjadi tidak optimal. Hal ini berpotensi menyebabkan duplikasi materi, kesenjangan pengetahuan, dan standar kualitas yang tidak konsisten.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-purple-600 font-medium">
                        <span>Solusi: Platform kolaborasi terintegrasi</span>
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Problem 4 --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                    <div class="bg-white bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Akses Santri Terbatas</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">
                        Santri mengalami kesulitan dalam mendapatkan akses ke materi pembelajaran terbaru dan terorganisir. Keterbatasan ini membatasi potensi pembelajaran mandiri dan menghambat perkembangan keterampilan santri dalam mengikuti perkembangan teknologi.
                    </p>
                    <div class="mt-4 flex items-center text-sm text-red-600 font-medium">
                        <span>Solusi: Sistem akses terpadu dan terverifikasi</span>
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Features Section --}}
    <div class="max-w-5xl mx-auto mb-12">
        <div class="text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Aplikasi</h2>
            <div class="h-1 w-24 bg-blue-600 mx-auto mb-6 rounded-full"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Aplikasi Pembelajaran Pondok IT ini dilengkapi dengan berbagai fitur canggih untuk mendukung proses belajar mengajar yang efektif dan efisien.
            </p>
        </div>
    </div>

    {{-- Features Grid --}}
    <div class="max-w-6xl mx-auto mb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Feature 1: Manajemen Pengguna --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <div class="bg-white bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-users w-6 h-6 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Manajemen Pengguna</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">
                        Admin memiliki kontrol penuh untuk mengelola akun santri, mentor, dan pengguna sistem lainnya. Memudahkan pengaturan peran dan akses.
                    </p>
                </div>
            </div>

            {{-- Feature 2: Manajemen Modul Pembelajaran --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4">
                    <div class="bg-white bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-book w-6 h-6 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Manajemen Modul</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">
                        Memungkinkan Admin dan Mentor untuk membuat, mengedit, menghapus, dan mengatur modul pembelajaran dengan mudah dan terstruktur.
                    </p>
                </div>
            </div>

            {{-- Feature 3: Pelacakan Kemajuan Modul --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-6 py-4">
                    <div class="bg-white bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line w-6 h-6 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Lacak Kemajuan</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">
                        Santri dapat menandai progres penyelesaian modul, dan Mentor dapat memantau secara real-time.
                    </p>
                </div>
            </div>

            {{-- Feature 4: Sistem Notifikasi --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="bg-gradient-to-r from-pink-600 to-pink-700 px-6 py-4">
                    <div class="bg-white bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-bell w-6 h-6 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Sistem Notifikasi</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">
                        Mendapatkan pemberitahuan otomatis untuk setiap aktivitas penting dalam aplikasi, memastikan tidak ada informasi yang terlewat.
                    </p>
                </div>
            </div>

            {{-- Feature 5: Sistem Pengumuman/Broadcast --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <div class="bg-white bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-bullhorn w-6 h-6 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Pengumuman Terpusat</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">
                        Admin dan Mentor dapat mengirim pengumuman penting secara massal ke santri atau mentor sesuai target audiens.
                    </p>
                </div>
            </div>

            {{-- Feature 6: Filter Jurusan --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <div class="bg-white bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-filter w-6 h-6 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Filter Jurusan</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">
                        Memudahkan pencarian dan penyaringan modul berdasarkan jurusan, baik untuk Admin maupun tampilan publik santri.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Vision Section --}}
    <div class="bg-blue-50 rounded-xl py-12 px-4 sm:px-6 mb-16">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Visi</h2>
            <p class="text-lg text-gray-700 mb-8">
                Menciptakan ekosistem pembelajaran yang terintegrasi, terstruktur, dan mudah diakses untuk meningkatkan kualitas pendidikan di Pondok IT dan mempersiapkan santri dalam menghadapi tantangan teknologi masa depan.
            </p>
            <div class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700">
                Mari Bersama Membangun Pendidikan IT Berkualitas
            </div>
        </div>
    </div>
@endsection
