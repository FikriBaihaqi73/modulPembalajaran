@extends('mentor.layout')

@section('title', 'Detail Modul')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Detail Modul</h2>

    <div class="mt-4 bg-white p-6 rounded shadow">
        <div class="mb-4">
            <p class="text-gray-700 text-sm font-bold">Nama Modul:</p>
            <p class="text-gray-900">{{ $module->name }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 text-sm font-bold">Kategori Modul:</p>
            <p class="text-gray-900">{{ $module->moduleCategory->name ?? 'N/A' }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 text-sm font-bold">Jurusan:</p>
            <p class="text-gray-900">{{ $module->major->name ?? 'N/A' }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 text-sm font-bold">Konten Modul:</p>
            <div class="prose max-w-none">
                {!! $module->content !!}
            </div>
        </div>
        <div class="flex items-center justify-between">
            <a href="{{ route('mentor.modules.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Kembali ke Daftar Modul
            </a>
        </div>
    </div>
@endsection
