@extends('mentor.layout')

@section('title', 'Manajemen Santri')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Manajemen Santri Jurusan Anda</h2>
    <div class="mt-4 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <a href="{{ route('mentor.santri.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Santri</a>

        <form action="{{ route('mentor.santri.index') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
            <input type="text" name="search" placeholder="Cari Santri..." value="{{ request('search') }}" class="border rounded px-3 py-2 w-full sm:w-auto">
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cari</button>
                @if(request('search'))
                    <a href="{{ route('mentor.santri.index') }}" class="text-red-600">Reset</a>
                @endif
            </div>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-center">Nomor</th>
                    <th class="py-2 px-4 border-b text-center">Username</th>
                    <th class="py-2 px-4 border-b text-center">Nama</th>
                    <th class="py-2 px-4 border-b text-center">Jurusan</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santri as $s)
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ (($santri->currentPage() - 1) * $santri->perPage()) + $loop->iteration }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $s->username }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $s->name }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $s->major->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('mentor.santri.edit', $s->id) }}" class="text-blue-600 mr-2">Edit</a>
                        <form action="{{ route('mentor.santri.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus santri ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-2 px-4 text-center">Tidak ada data santri.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Links --}}
    <div class="flex justify-center my-8">
        {{ $santri->links() }}
    </div>
@endsection
