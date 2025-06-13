@extends('mentor.layout')

@section('title', 'Mentor Dashboard')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Selamat Datang di Mentor Dashboard!</h2>
    <p class="mt-4 text-gray-600">Di sini Anda dapat mengelola modul pembelajaran Anda.</p>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Total Modul</h3>
            <p class="text-gray-600 text-3xl">{{ $totalModules }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Total Kategori Modul</h3>
            <p class="text-gray-600 text-3xl">{{ $totalModuleCategories }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Total Santri Jurusan Anda</h3>
            <p class="text-gray-600 text-3xl">{{ $totalSantri }}</p>
        </div>
    </div>

    <!-- You can add more mentor-specific content here -->
@endsection
