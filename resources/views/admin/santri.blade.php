@extends('admin.layout')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Santri Management</h2>
    <div class="mt-4 mb-4">
        <a href="{{ route('admin.santri.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Santri</a>
    </div>
    <div>
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-center">nomor</th>
                    <th class="py-2 px-4 border-b text-center">Username</th>
                    <th class="py-2 px-4 border-b text-center">Nama</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santri as $s)
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $s->username }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $s->name }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('admin.santri.edit', $s->id) }}" class="text-blue-600 mr-2">Edit</a>
                        <form action="{{ route('admin.santri.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus santri?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-2 px-4 text-center">Tidak ada data santri.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
