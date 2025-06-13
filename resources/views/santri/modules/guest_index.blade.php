@extends('santri.layouts.app')

@section('title', 'Daftar Modul')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-800 shadow-xl">
            <div class="absolute inset-0 bg-pattern opacity-10"></div>
            <div class="relative px-6 py-20 md:py-28 flex flex-col items-center justify-center text-center">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-6 tracking-tight">
                    Akses Modul Pembelajaran
                </h2>
                <div class="max-w-2xl mx-auto">
                    <p class="text-xl text-blue-100 mb-4">
                        Selamat datang di platform modul pembelajaran Pondok IT.
                    </p>
                    <p class="text-lg text-blue-100 mb-8">
                        Login dengan akun yang sudah disediakan untuk melihat modul. Jika belum punya akun, silahkan hubungi <span class="font-semibold">Admin Pondok IT</span> atau <span class="font-semibold">Mentor</span> Anda.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-lg text-base font-medium text-blue-700 bg-white hover:bg-blue-50 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-800 focus:ring-white">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Login Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Features or Benefits Section --}}
        <div class="py-16">
            <div class="text-center mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Mengapa Menggunakan Platform Ini?</h3>
                <p class="text-gray-600 max-w-2xl mx-auto">Berikut beberapa manfaat yang akan Anda dapatkan dengan menggunakan platform modul pembelajaran kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="text-center mb-4">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600 mb-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">Materi Terstruktur</h4>
                    </div>
                    <p class="text-gray-600 text-center">Akses modul pembelajaran yang disusun secara terstruktur dan sistematis untuk memudahkan pemahaman.</p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="text-center mb-4">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-green-100 text-green-600 mb-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">Kemudahan Akses</h4>
                    </div>
                    <p class="text-gray-600 text-center">Buka dan unduh modul kapan saja, memudahkan Anda untuk belajar sesuai dengan jadwal yang fleksibel.</p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="text-center mb-4">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 text-purple-600 mb-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">Konten Berkualitas</h4>
                    </div>
                    <p class="text-gray-600 text-center">Materi pembelajaran yang selalu diperbarui dan disusun oleh mentor berpengalaman sesuai perkembangan industri.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
@endsection
