@extends('admin.layout')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Mentor Management</h2>
    <div class="mt-4 mb-4">
        <a href="{{ route('admin.mentor.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Mentor</a>
    </div>
    <div>
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-center">nomor</th>
                    <th class="py-2 px-4 border-b text-center">Username</th>
                    <th class="py-2 px-4 border-b text-center">Nama</th>
                    <th class="py-2 px-4 border-b text-center">Jurusan</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mentor as $m)
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $m->username }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $m->name }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $m->major->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('admin.mentor.edit', $m->id) }}" class="text-blue-600 mr-2">Edit</a>
                        <form action="{{ route('admin.mentor.destroy', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus mentor?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-2 px-4 text-center">Tidak ada data mentor.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
