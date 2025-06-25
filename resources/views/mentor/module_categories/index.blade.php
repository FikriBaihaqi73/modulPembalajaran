@extends('mentor.layout')

@section('title', 'Kategori Modul')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Manajemen Kategori Modul</h2>
    <div class="mt-4 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <a href="{{ route('mentor.module-categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Kategori Modul</a>

        <form action="{{ route('mentor.module-categories.index') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
            <input type="text" name="search" placeholder="Cari Kategori Modul..." value="{{ request('search') }}" class="border rounded px-3 py-2 w-full sm:w-auto">
            <select name="is_visible" class="border rounded px-3 py-2 w-full sm:w-auto">
                <option value="">Semua Visibilitas</option>
                <option value="1" {{ request('is_visible') === '1' ? 'selected' : '' }}>Terlihat</option>
                <option value="0" {{ request('is_visible') === '0' ? 'selected' : '' }}>Tersembunyi</option>
            </select>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cari & Filter</button>
                @if(request('search') || request('is_visible'))
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
                    <th class="py-2 px-4 border-b text-center">Visibilitas</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($moduleCategories as $category)
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ (($moduleCategories->currentPage() - 1) * $moduleCategories->perPage()) + $loop->iteration }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $category->name }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $category->major->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        <form action="{{ route('mentor.module-categories.toggleVisibility', $category->id) }}" method="POST" class="inline-block">
                            @csrf
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_visible" value="1" class="sr-only peer" onchange="this.form.submit()" {{ $category->is_visible ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900">{{ $category->is_visible ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </label>
                        </form>
                    </td>
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
                    <td colspan="5" class="py-2 px-4 text-center">Tidak ada kategori modul.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Links --}}
    <div class="flex justify-center my-8">
        {{ $moduleCategories->links() }}
    </div>
@endsection
