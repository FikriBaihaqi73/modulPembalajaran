@extends('admin.layout')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Santri Management</h2>
    <div class="mt-4">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">#</th>
                    <th class="py-2 px-4 border-b">Username</th>
                    <th class="py-2 px-4 border-b">Nama</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santri as $s)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4 border-b">{{ $s->username }}</td>
                    <td class="py-2 px-4 border-b">{{ $s->name }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-2 px-4 text-center">Tidak ada data santri.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
