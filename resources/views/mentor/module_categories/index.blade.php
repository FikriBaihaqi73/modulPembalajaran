@extends('mentor.layout')

@section('title', 'Kategori Modul')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Manajemen Kategori Modul</h2>
    <div class="mt-4 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <a href="{{ route('mentor.module-categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Kategori Modul</a>

        <form action="{{ route('mentor.module-categories.index') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
            <input type="text" name="search" placeholder="Cari Kategori Modul..." value="{{ request('search') }}" class="border rounded px-3 py-2 w-full sm:w-auto">
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cari</button>
                @if(request('search'))
                    <a href="{{ route('mentor.module-categories.index') }}" class="text-red-600">Reset</a>
                @endif
            </div>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-center">Nomor</th>
                    <th class="py-2 px-4 border-b text-center">Nama Kategori</th>
                    <th class="py-2 px-4 border-b text-center">Jurusan</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($moduleCategories as $category)
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $category->name }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $category->major->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('mentor.module-categories.edit', $category->id) }}" class="text-blue-600 mr-2">Edit</a>
                        <form action="{{ route('mentor.module-categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori modul ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-2 px-4 text-center">Tidak ada kategori modul.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Links --}}
    <div class="mt-4">
        {{ $moduleCategories->links() }}
    </div>
@endsection
