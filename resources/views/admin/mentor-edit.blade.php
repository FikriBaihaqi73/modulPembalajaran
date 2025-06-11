@extends('admin.layout')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Edit Mentor</h2>
<form action="{{ route('mentor.update', $mentor->id) }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label class="block mb-1">Username</label>
        <input type="text" name="username" class="w-full border rounded px-3 py-2" value="{{ $mentor->username }}" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1">Nama</label>
        <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ $mentor->name }}" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1">Password (isi jika ingin ganti)</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2">
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    <a href="{{ route('mentor.index') }}" class="ml-2 text-gray-600">Batal</a>
</form>
@endsection
