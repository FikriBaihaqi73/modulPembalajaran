@extends('admin.layout')

@section('title', 'Manajemen Jurusan')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-3xl font-semibold text-gray-800">Manajemen Jurusan</h2>

        <div class="mt-4 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <a href="{{ route('admin.majors.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                <i class="fas fa-plus mr-2"></i>
                Tambah Jurusan Baru
            </a>

            <form action="{{ route('admin.majors.index') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
                <input type="text" name="search" placeholder="Cari jurusan..." value="{{ request('search') }}" class="border rounded px-3 py-2 w-full sm:w-auto">
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.majors.index') }}" class="text-red-600">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-center">Nomor</th>
                        <th class="py-2 px-4 border-b text-center">Nama Jurusan</th>
                        <th class="py-2 px-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($majors as $major)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ (($majors->currentPage() - 1) * $majors->perPage()) + $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $major->name }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('admin.majors.edit', $major->id) }}" class="text-blue-600 mr-2">Edit</a>
                                <form action="{{ route('admin.majors.destroy', $major->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan ini? Ini akan menghapus semua santri dan mentor yang terkait dengan jurusan ini.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-2 px-4 text-center">Tidak ada jurusan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="flex justify-center my-8">
            {{ $majors->links() }}
        </div>
    </div>
@endsection
