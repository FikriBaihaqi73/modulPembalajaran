@extends('mentor.layout')

@section('title', 'Detail Modul')

@section('content')
    <div class="bg-white p-6 rounded shadow mb-6">
        {{-- Thumbnail --}}
        @if ($module->thumbnail)
            <div class="flex justify-center mb-6">
                <img src="{{ $module->thumbnail }}" alt="Thumbnail Modul" class="w-full max-w-screen-md h-auto object-cover rounded-lg shadow-md">
            </div>
        @endif

        {{-- Title --}}
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $module->name }}</h1>

        {{-- Creation Date --}}
        <p class="text-gray-600 text-sm mb-4">
            Dibuat pada: {{ \Carbon\Carbon::parse($module->created_at)->locale('id')->translatedFormat('d F Y, H:i') }}
        </p>

        {{-- Categories and Major --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 mb-6">
            <div>
                <p class="font-bold">Kategori Modul:</p>
                <p>
                    @forelse($module->moduleCategory as $category)
                        <span class="inline-block bg-blue-200 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $category->name }}</span>@if(!$loop->last), @endif
                    @empty
                        N/A
                    @endforelse
                </p>
            </div>
            <div>
                <p class="font-bold">Jurusan:</p>
                <p>{{ $module->major->name ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Module Content --}}
        <div class="prose max-w-none text-gray-800 leading-relaxed">
            {!! $module->content !!}
        </div>

        <hr class="my-6 border-gray-300">

        <div class="mt-6">
            <a href="{{ route('mentor.modules.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Modul
            </a>
        </div>
    </div>
@endsection
