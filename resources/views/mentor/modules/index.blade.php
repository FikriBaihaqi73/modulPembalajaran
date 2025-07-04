@extends('mentor.layout')

@section('title', 'Manajemen Modul')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Manajemen Modul Pembelajaran</h2>
    <div class="mt-4 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <a href="{{ route('mentor.modules.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Modul</a>

        <form action="{{ route('mentor.modules.index') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
            <input type="text" name="search" placeholder="Cari Modul..." value="{{ request('search') }}" class="border rounded px-3 py-2 w-full sm:w-auto">
            <select name="module_category_id" class="border rounded px-3 py-2 w-full sm:w-auto">
                <option value="">Semua Kategori</option>
                @foreach($moduleCategories as $category)
                    <option value="{{ $category->id }}" {{ request('module_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cari & Filter</button>
                @if(request('search') || request('module_category_id'))
                    <a href="{{ route('mentor.modules.index') }}" class="text-red-600">Reset</a>
                @endif
            </div>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-center">Nomor</th>
                    <th class="py-2 px-4 border-b text-center">Nama Modul</th>
                    <th class="py-2 px-4 border-b text-center">Thumbnail</th>
                    <th class="py-2 px-4 border-b text-center">Content</th>
                    <th class="py-2 px-4 border-b text-center">Kategori</th>
                    <th class="py-2 px-4 border-b text-center">Jurusan</th>
                    <th class="py-2 px-4 border-b text-center">Visibilitas</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modules as $module)
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ (($modules->currentPage() - 1) * $modules->perPage()) + $loop->iteration }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $module->name }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        @if ($module->thumbnail)
                            <img src="{{ $module->thumbnail }}" alt="Thumbnail" class="h-12 w-12 object-cover rounded-full mx-auto">
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b text-center">{!! Str::limit(strip_tags($module->content), 50) !!}</td>
                    <td class="py-2 px-4 border-b text-center">
                        @forelse($module->moduleCategory as $category)
                            <span class="inline-block bg-blue-200 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $category->name }}</span>@if(!$loop->last),@endif
                        @empty
                            N/A
                        @endforelse
                    </td>
                    <td class="py-2 px-4 border-b text-center">{{ $module->major->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        <form action="{{ route('mentor.modules.toggleVisibility', $module->id) }}" method="POST" class="inline-block">
                            @csrf
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_visible" value="1" class="sr-only peer" onchange="this.form.submit()" {{ $module->is_visible ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900">{{ $module->is_visible ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </label>
                        </form>
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('mentor.modules.show', $module->id) }}" class="text-green-600 mr-2">Lihat</a>
                        <a href="{{ route('mentor.modules.edit', $module->id) }}" class="text-blue-600 mr-2">Edit</a>
                        <form action="{{ route('mentor.modules.destroy', $module->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus modul ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-2 px-4 text-center">Tidak ada modul.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Links --}}
    <div class="flex justify-center my-8">
        {{ $modules->links() }}
    </div>
@endsection
