@extends('admin.layout')

@section('title', 'Detail Modul')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden mb-8">
        {{-- Back link - mobile friendly top navigation --}}
        <div class="bg-gray-50 py-3 px-4 sm:px-6 border-b flex items-center">
            <a href="{{ route('admin.modules.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Modul
            </a>
        </div>

        {{-- Thumbnail --}}
        @if ($module->thumbnail)
            <div class="w-full aspect-video overflow-hidden bg-gray-100">
                <img src="{{ $module->thumbnail }}" alt="Thumbnail Modul" class="w-full h-full object-contain">
            </div>
        @endif

        <div class="px-4 py-5 sm:px-6">
            {{-- Title with badge indicator --}}
            <div class="flex flex-wrap items-start justify-between">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight mb-1">{{ $module->name }}</h1>
            </div>

            {{-- Metadata row --}}
            <div class="mt-2 flex flex-wrap items-center text-sm text-gray-500 space-x-4">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($module->created_at)->locale('id')->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($module->created_at)->format('H:i') }}</span>
                </div>
            </div>

            {{-- Categories --}}
            <div class="mt-4 flex flex-wrap gap-2">
                @forelse($module->moduleCategory as $category)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $category->name }}
                    </span>
                @empty
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Tidak ada kategori
                    </span>
                @endforelse
                @if($module->major)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        {{ $module->major->name }}
                    </span>
                @endif
            </div>

            {{-- Admin does not download PDF --}}

        </div>

        {{-- Content Divider --}}
        <div class="border-t border-gray-200"></div>

        {{-- Module Content --}}
        <div class="px-4 py-5 sm:px-6">
            <div class="prose prose-sm sm:prose max-w-none text-gray-800 leading-relaxed">
                {!! $module->content !!}
            </div>
        </div>
    </div>
@endsection
