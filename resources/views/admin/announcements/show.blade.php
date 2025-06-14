@extends('admin.layout')

@section('title', 'Detail Pengumuman')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-4">Detail Pengumuman</h2>

        <div class="bg-white p-6 rounded shadow mb-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul Pengumuman:</label>
                <p class="mt-1 text-lg font-bold text-gray-900">{{ $announcement->title }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Konten Pengumuman:</label>
                <p class="mt-1 text-gray-800">{{ $announcement->content }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Pengirim:</label>
                <p class="mt-1 text-gray-800">{{ $announcement->user->name ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Target Audiens:</label>
                <p class="mt-1 text-gray-800">{{ ucfirst($announcement->target_audience) }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Jurusan:</label>
                <p class="mt-1 text-gray-800">{{ $announcement->major->name ?? 'Semua Jurusan' }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Publikasi:</label>
                <p class="mt-1 text-gray-800">{{ $announcement->published_at ? $announcement->published_at->format('d M Y H:i') : 'Sekarang' }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa:</label>
                <p class="mt-1 text-gray-800">{{ $announcement->expires_at ? $announcement->expires_at->format('d M Y H:i') : 'Tidak Ada' }}</p>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded">
                    Edit Pengumuman
                </a>
                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">
                        Hapus Pengumuman
                    </button>
                </form>
                <a href="{{ route('admin.announcements.index') }}" class="ml-2 text-gray-600 px-4 py-2 rounded border">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection
