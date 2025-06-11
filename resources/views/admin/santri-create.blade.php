@extends('admin.layout')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Tambah Santri</h2>
<form action="{{ route('admin.santri.store') }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
    @csrf
    <div class="mb-4">
        <label class="block mb-1">Username</label>
        <input type="text" name="username" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1">Nama</label>
        <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    <a href="{{ route('admin.santri.index') }}" class="ml-2 text-gray-600">Batal</a>
</form>
@endsection
