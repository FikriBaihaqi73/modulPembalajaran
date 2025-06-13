@extends('santri.layouts.app')

@section('title', 'Home - Modul Pembelajaran Santri Pondok IT')

@section('content')
    {{-- Hero Section with Background --}}
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-800 rounded-2xl overflow-hidden shadow-xl mb-16">
        <div class="absolute inset-0 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                <defs>
                    <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
                        <path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 py-16 lg:py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 tracking-tight">
                Modul Pembelajaran Santri Pondok IT
            </h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-3xl mx-auto mb-8">
                Platform terintegrasi untuk membuat, mengelola, membaca, dan mengunduh modul pembelajaran dengan mudah.
            </p>
            <div class="mt-8">
                <a href="{{ route('santri.modules.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-indigo-700 bg-white hover:bg-indigo-50 transition duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Jelajahi Modul
                </a>
            </div>
        </div>
    </div>

    {{-- Features Section with Icons --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 mb-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Fitur Unggulan</h2>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                Sistem yang dikembangkan untuk memudahkan akses modul pembelajaran bagi santri Pondok IT
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Feature 1 --}}
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="bg-indigo-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 text-center mb-2">Penyimpanan Terpusat</h3>
                <p class="text-gray-600 text-center">
                    Semua modul tersimpan rapih di satu tempat, tidak bercampur dengan pesan lain seperti di WhatsApp.
                </p>
            </div>

            {{-- Feature 2 --}}
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 text-center mb-2">Akses Offline</h3>
                <p class="text-gray-600 text-center">
                    Unduh modul dan dapatkan file pdf untuk dibaca kapan saja, di mana saja, tanpa koneksi internet.
                </p>
            </div>

            {{-- Feature 3 --}}
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="bg-yellow-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 text-center mb-2">Tampilan Mudah Dipahami</h3>
                <p class="text-gray-600 text-center">
                    Desain antarmuka yang sederhana dan intuitif, membuat belajar lebih menyenangkan.
                </p>
            </div>
        </div>
    </div>

    {{-- CTA Section --}}
    <div class="bg-gray-50 rounded-2xl shadow-inner py-12 px-4 sm:px-6 mb-16">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Mulai Belajar Sekarang</h2>
            <p class="text-lg text-gray-600 mb-8 max-w-3xl mx-auto">
                Akses modul pembelajaran yang telah disusun oleh mentor terbaik untuk mengembangkan keterampilan Anda.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('santri.modules.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-200">
                    Lihat Semua Modul
                </a>
                <a href="{{ route('santri.about') }}" class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
                    Tentang Aplikasi
                </a>
            </div>
        </div>
    </div>
@endsection
