@extends('mentor.layout')

@section('title', 'Mentor Dashboard')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Selamat Datang di Mentor Dashboard!</h2>
        <p class="mt-2 text-gray-600">Di sini Anda dapat mengelola modul pembelajaran Anda.</p>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-300">
            <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 text-center mb-2">Total Modul</h3>
            <p class="text-gray-600 text-3xl text-center font-bold">{{ $totalModules }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-300">
            <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3H14V7H10V3ZM17 3H21V7H17V3ZM3 10H7V14H3V10ZM10 10H14V14H10V10ZM17 10H21V14H17V10ZM3 17H7V21H3V17ZM10 17H14V21H10V17ZM17 17H21V21H17V17Z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 text-center mb-2">Total Kategori Modul</h3>
            <p class="text-gray-600 text-3xl text-center font-bold">{{ $totalModuleCategories }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-300">
            <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 text-center mb-2">Total Santri Jurusan Anda</h3>
            <p class="text-gray-600 text-3xl text-center font-bold">{{ $totalSantri }}</p>
        </div>
    </div>

    <div class="mt-10 bg-white rounded-xl shadow-md p-8 border border-gray-100">
        <div class="flex items-center mb-6">
            <div class="bg-blue-100 rounded-full p-2 mr-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Tips untuk Mentor</h3>
        </div>
        <ul class="space-y-3 text-gray-600">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Pastikan untuk selalu memperbarui modul pembelajaran Anda secara berkala.</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Gunakan kategori untuk mengorganisir modul dengan baik.</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Tambahkan thumbnail yang relevan untuk meningkatkan tampilan modul Anda.</span>
            </li>
        </ul>
    </div>
@endsection
