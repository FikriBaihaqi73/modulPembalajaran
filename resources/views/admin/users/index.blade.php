@extends('admin.layout')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-3xl font-semibold text-gray-800">Manajemen Pengguna</h2>

        <div class="mt-4 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                <i class="fas fa-plus mr-2"></i>
                Tambah Pengguna Baru
            </a>

            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
                <input type="text" name="search" placeholder="Cari pengguna..." value="{{ request('search') }}" class="border rounded px-3 py-2 w-full sm:w-auto">

                <select name="role_id" class="border rounded px-3 py-2 w-full sm:w-auto">
                    <option value="">Semua Peran</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>

                <select name="major_id" class="border rounded px-3 py-2 w-full sm:w-auto">
                    <option value="">Semua Jurusan</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                    @endforeach
                </select>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cari & Filter</button>
                    @if(request('search') || request('role_id') || request('major_id'))
                        <a href="{{ route('admin.users.index') }}" class="text-red-600">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-center">Nomor</th>
                        <th class="py-2 px-4 border-b text-center">Nama</th>
                        <th class="py-2 px-4 border-b text-center">Username</th>
                        <th class="py-2 px-4 border-b text-center">Peran</th>
                        <th class="py-2 px-4 border-b text-center">Jurusan</th>
                        <th class="py-2 px-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ (($users->currentPage() - 1) * $users->perPage()) + $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $user->name }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $user->username }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role->name === 'Admin' ? 'bg-red-100 text-red-800' : ($user->role->name === 'Mentor' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $user->role->name }}
                                </span>
                            </td>
                            <td class="py-2 px-4 border-b text-center">{{ $user->major->name ?? '-' }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 mr-2">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-2 px-4 text-center">Tidak ada pengguna ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="flex justify-center my-8">
            {{ $users->links() }}
        </div>
    </div>
@endsection
