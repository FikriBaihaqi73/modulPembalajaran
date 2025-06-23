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
        <label class="block mb-1">Jurusan</label>
        <select name="major_id" class="w-full border rounded px-3 py-2" required>
            <option value="">Pilih Jurusan</option>
            @foreach($majors as $major)
                <option value="{{ $major->id }}">{{ $major->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-4">
        <label class="block mb-1">Password</label>
        <div class="relative" x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" name="password" class="w-full border rounded px-3 py-2 pr-10 @error('password') border-red-500 @enderror" required>
            <i class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500" @click="show = !show" :class="{'fa fa-eye': !show, 'fa fa-eye-slash': show}"></i>
        </div>
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Konfirmasi Password</label>
        <div class="relative" x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" name="password_confirmation" class="w-full border rounded px-3 py-2 pr-10 @error('password') border-red-500 @enderror" required>
            <i class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500" @click="show = !show" :class="{'fa fa-eye': !show, 'fa fa-eye-slash': show}"></i>
        </div>
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    <a href="{{ route('admin.santri.index') }}" class="ml-2 text-gray-600">Batal</a>
</form>
@endsection
