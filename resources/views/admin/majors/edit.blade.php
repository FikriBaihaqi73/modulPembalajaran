@extends('admin.layout')

@section('title', 'Edit Jurusan')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Jurusan</h2>

        <form action="{{ route('admin.majors.update', $major->id) }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block mb-1">Nama Jurusan</label>
                <input type="text" name="name" id="name" value="{{ old('name', $major->name) }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.majors.index') }}" class="ml-2 text-gray-600">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Perbarui Jurusan
                </button>
            </div>
        </form>
    </div>
@endsection