@extends('mentor.layout')

@section('title', 'Pengumuman Saya')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-3xl font-semibold text-gray-800">Pengumuman Saya</h2>

        <div class="mt-4 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <a href="{{ route('mentor.announcements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                <i class="fas fa-plus mr-2"></i>
                Buat Pengumuman Baru
            </a>

            <form action="{{ route('mentor.announcements.index') }}" method="GET" class="flex items-center gap-3">
                <input type="text" name="search" placeholder="Cari pengumuman..." value="{{ request('search') }}" class="border rounded px-3 py-2">
                <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cari</button>
                @if(request('search'))
                    <a href="{{ route('mentor.announcements.index') }}" class="text-red-600">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-center">Judul</th>
                        <th class="py-2 px-4 border-b text-center">Target Audiens</th>
                        <th class="py-2 px-4 border-b text-center">Jurusan</th>
                        <th class="py-2 px-4 border-b text-center">Dipublikasikan</th>
                        <th class="py-2 px-4 border-b text-center">Kadaluarsa</th>
                        <th class="py-2 px-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($announcements as $announcement)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ $announcement->title }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ ucfirst($announcement->target_audience) }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $announcement->major->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $announcement->published_at->format('d M Y H:i') }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $announcement->expires_at ? $announcement->expires_at->format('d M Y H:i') : 'Tidak Ada' }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('mentor.announcements.show', $announcement->id) }}" class="text-blue-600 mr-2">Lihat</a>
                                <a href="{{ route('mentor.announcements.edit', $announcement->id) }}" class="text-yellow-600 mr-2">Edit</a>
                                <form action="{{ route('mentor.announcements.destroy', $announcement->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-2 px-4 text-center">Tidak ada pengumuman ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="mt-4">
            {{ $announcements->links() }}
        </div>
    </div>
@endsection
