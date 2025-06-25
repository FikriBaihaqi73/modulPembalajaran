@extends('admin.layout')

@section('title', 'Tambah Jurusan Baru')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Jurusan Baru</h2>

        <form action="{{ route('admin.majors.store') }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label for="name" class="block mb-1">Nama Jurusan</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.majors.index') }}" class="ml-2 text-gray-600">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan Jurusan
                </button>
            </div>
        </form>
    </div>
@endsection
