@extends('admin.layout')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
        <p class="mt-1 text-gray-600">Selamat datang di panel admin Pondok IT</p>
    </div>

    <div class="mt-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-600 bg-opacity-75 text-white">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 21H7C4.79 21 3 19.21 3 17V7C3 4.79 4.79 3 7 3H17C19.21 3 21 4.79 21 7V17C21 19.21 19.21 21 17 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12 14C8.68629 14 6 16.6863 6 20H18C18 16.6863 15.3137 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-bold text-gray-700">{{ $totalSantri }}</h4>
                        <div class="text-gray-500">Total Santri</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-md rounded-lg p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-600 bg-opacity-75 text-white">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 21H7C4.79 21 3 19.21 3 17V7C3 4.79 4.79 3 7 3H17C19.21 3 21 4.79 21 7V17C21 19.21 19.21 21 17 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12 14C8.68629 14 6 16.6863 6 20H18C18 16.6863 15.3137 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-bold text-gray-700">{{ $totalMentor }}</h4>
                        <div class="text-gray-500">Total Mentor</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
