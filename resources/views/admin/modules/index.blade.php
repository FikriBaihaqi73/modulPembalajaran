@extends('admin.layout')

@section('title', 'Manajemen Modul')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Manajemen Modul Pembelajaran</h2>
    <div class="mt-4 mb-4 flex justify-between items-center">
        {{-- Admin tidak membuat modul, hanya melihat dan mengelola --}}
        {{-- <a href="{{ route('admin.modules.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Modul</a> --}}

        <form action="{{ route('admin.modules.index') }}" method="GET" class="flex items-center space-x-4">
            <input type="text" name="search" placeholder="Cari Modul..." value="{{ request('search') }}" class="border rounded px-3 py-2">
            <select name="major_id" class="border rounded px-3 py-2">
                <option value="">Semua Jurusan</option>
                @foreach($majors as $major)
                    <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cari & Filter</button>
            @if(request('search') || request('major_id'))
                <a href="{{ route('admin.modules.index') }}" class="text-red-600">Reset</a>
            @endif
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
                    <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
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
                        {{-- Admin hanya melihat, tidak mengubah visibilitas langsung dari sini --}}
                        <span class="inline-block bg-{{ $module->is_visible ? 'green' : 'red' }}-200 text-{{ $module->is_visible ? 'green' : 'red' }}-800 text-xs px-2 py-1 rounded-full">
                            {{ $module->is_visible ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('admin.modules.show', $module->id) }}" class="text-green-600 mr-2">Lihat</a>
                        {{-- Admin tidak bisa edit/hapus modul, hanya mentor --}}
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
    <div class="mt-4">
        {{ $modules->links() }}
    </div>
@endsection
