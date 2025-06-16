@extends('mentor.layout')

@section('title', 'Lacak Kemajuan Modul')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Lacak Kemajuan Modul Santri</h2>

        {{-- Search and Filter Form Container --}}
        <div class="mt-4 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <form action="{{ route('mentor.module-progress.index') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
                <input type="text" name="search" placeholder="Cari modul..." value="{{ request('search') }}" class="border rounded px-3 py-2 w-full sm:w-auto">
                <select name="category_id" class="border rounded px-3 py-2 w-full sm:w-auto">
                    <option value="">Semua Kategori</option>
                    @foreach ($moduleCategories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cari & Filter</button>
                    @if(request('search') || request('category_id'))
                        <a href="{{ route('mentor.module-progress.index') }}" class="text-red-600">Reset</a>
                    @endif
                </div>
            </form>
        </div>

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
                            <div class="flex items-center text-sm text-gray-700 mb-2">
                                <span class="mr-1">Rating:</span>
                                @if($module->reviews->count() > 0)
                                    <span class="font-semibold text-yellow-500">{{ number_format($module->average_rating, 1) }}</span>/5
                                    <span class="ml-1 text-gray-500">({{ $module->reviews->count() }} ulasan)</span>
                                @else
                                    <span class="text-gray-500">Belum ada ulasan</span>
                                @endif
                            </div>
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

            {{-- Pagination Links --}}
            <div class="flex justify-center my-8">
                {{ $modules->appends(request()->except('page'))->links() }}
            </div>
        @endif
    </div>
@endsection
