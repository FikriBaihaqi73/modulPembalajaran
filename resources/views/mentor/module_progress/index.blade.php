@extends('mentor.layout')

@section('title', 'Lacak Kemajuan Modul')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Lacak Kemajuan Modul Santri</h2>

        @if ($modules->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <p class="text-gray-600">Anda belum memiliki modul yang dibuat.</p>
                <a href="{{ route('mentor.modules.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Buat Modul Baru
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($modules as $module)
                    <a href="{{ route('mentor.module-progress.show', $module->id) }}" class="block bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 line-clamp-1">{{ $module->name }}</h3>
                            <p class="text-sm text-gray-600 mb-4">Dibuat pada: {{ \Carbon\Carbon::parse($module->created_at)->locale('id')->translatedFormat('d F Y') }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Santri Melacak: <span class="font-semibold">{{ $module->progress->count() }}</span></span>
                                @php
                                    $completedCount = $module->progress->where('is_completed', true)->count();
                                    $totalTracking = $module->progress->count();
                                    $completionPercentage = $totalTracking > 0 ? round(($completedCount / $totalTracking) * 100) : 0;
                                @endphp
                                <span class="text-sm font-semibold {{ $completionPercentage == 100 ? 'text-green-600' : 'text-blue-600' }}">{{ $completionPercentage }}% Selesai</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
