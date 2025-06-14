@extends('mentor.layout')

@section('title', 'Edit Pengumuman')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Pengumuman</h2>

        <form action="{{ route('mentor.announcements.update', $announcement->id) }}" method="POST" class="max-w-xl bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block mb-1">Judul Pengumuman</label>
                <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror" required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block mb-1">Konten Pengumuman</label>
                <textarea name="content" id="content" rows="6" class="w-full border rounded px-3 py-2 @error('content') border-red-500 @enderror" required>{{ old('content', $announcement->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="published_at" class="block mb-1">Tanggal Publikasi (Opsional, default: sekarang)</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $announcement->published_at ? $announcement->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" class="w-full border rounded px-3 py-2 @error('published_at') border-red-500 @enderror">
                @error('published_at')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="expires_at" class="block mb-1">Tanggal Kadaluarsa (Opsional)</label>
                <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at', $announcement->expires_at ? $announcement->expires_at->format('Y-m-d\TH:i') : '') }}" class="w-full border rounded px-3 py-2 @error('expires_at') border-red-500 @enderror">
                @error('expires_at')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('mentor.announcements.index') }}" class="ml-2 text-gray-600">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Perbarui Pengumuman
                </button>
            </div>
        </form>
    </div>
@endsection
