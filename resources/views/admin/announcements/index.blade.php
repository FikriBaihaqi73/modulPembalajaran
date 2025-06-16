@extends('admin.layout')

@section('title', 'Manajemen Pengumuman')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-3xl font-semibold text-gray-800">Manajemen Pengumuman</h2>

        <div class="mt-4 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <a href="{{ route('admin.announcements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                <i class="fas fa-plus mr-2"></i>
                Buat Pengumuman Baru
            </a>

            <form action="{{ route('admin.announcements.index') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
                <input type="text" name="search" placeholder="Cari pengumuman..." value="{{ request('search') }}" class="border rounded px-3 py-2 w-full sm:w-auto">

                <select name="target_audience" class="border rounded px-3 py-2 w-full sm:w-auto">
                    <option value="">Semua Audiens</option>
                    <option value="all" {{ request('target_audience') == 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="santri" {{ request('target_audience') == 'santri' ? 'selected' : '' }}>Santri</option>
                    <option value="mentor" {{ request('target_audience') == 'mentor' ? 'selected' : '' }}>Mentor</option>
                </select>

                <select name="major_id" class="border rounded px-3 py-2 w-full sm:w-auto">
                    <option value="">Semua Jurusan</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                    @endforeach
                </select>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cari & Filter</button>
                    @if(request('search') || request('target_audience') || request('major_id'))
                        <a href="{{ route('admin.announcements.index') }}" class="text-red-600">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-center">Judul</th>
                        <th class="py-2 px-4 border-b text-center">Pengirim</th>
                        <th class="py-2 px-4 border-b text-center">Audiens Target</th>
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
                            <td class="py-2 px-4 border-b text-center">{{ $announcement->user->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ ucfirst($announcement->target_audience) }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $announcement->major->name ?? 'Semua' }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $announcement->published_at->format('d M Y H:i') }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $announcement->expires_at ? $announcement->expires_at->format('d M Y H:i') : 'Tidak Ada' }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="text-blue-600 mr-2">Lihat</a>
                                <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="text-yellow-600 mr-2">Edit</a>
                                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-2 px-4 text-center">Tidak ada pengumuman ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="flex justify-center my-8">
            {{ $announcements->links() }}
        </div>
    </div>
@endsection
