@extends('mentor.layout')

@section('title', 'Manajemen Modul')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Manajemen Modul Pembelajaran</h2>
    <div class="mt-4 mb-4">
        <a href="{{ route('mentor.modules.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Modul</a>
    </div>
    <div>
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-center">Nomor</th>
                    <th class="py-2 px-4 border-b text-center">Nama Modul</th>
                    <th class="py-2 px-4 border-b text-center">Content</th>
                    <th class="py-2 px-4 border-b text-center">Kategori</th>
                    <th class="py-2 px-4 border-b text-center">Jurusan</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modules as $module)
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $module->name }}</td>
                    <td class="py-2 px-4 border-b text-center">{!! Str::limit(strip_tags($module->content), 50) !!}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $module->moduleCategory->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $module->major->name ?? 'N/A' }}</td>
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
                    <td colspan="6" class="py-2 px-4 text-center">Tidak ada modul.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
