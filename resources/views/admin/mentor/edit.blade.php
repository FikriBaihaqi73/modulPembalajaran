@extends('admin.layout')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Edit Mentor</h2>
<form action="{{ route('admin.mentor.update', $mentor->id) }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
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
        <label class="block mb-1">Jurusan</label>
        <select name="major_id" class="w-full border rounded px-3 py-2" required>
            <option value="">Pilih Jurusan</option>
            @foreach($majors as $major)
                <option value="{{ $major->id }}" {{ $mentor->major_id == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-4">
        <label class="block mb-1">Password (isi jika ingin ganti)</label>
        <div class="relative" x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" name="password" id="adminMentorEditPassword" class="w-full border rounded px-3 py-2 pr-10 @error('password') border-red-500 @enderror">
            <i class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500" @click="show = !show" :class="{'fa fa-eye': !show, 'fa-eye-slash': show}"></i>
        </div>
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Konfirmasi Password</label>
        <div class="relative" x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" name="password_confirmation" id="adminMentorEditPasswordConfirmation" class="w-full border rounded px-3 py-2 pr-10 @error('password_confirmation') border-red-500 @enderror">
            <i class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500" @click="show = !show" :class="{'fa fa-eye': !show, 'fa-eye-slash': show}"></i>
        </div>
        @error('password_confirmation')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    <a href="{{ route('admin.mentor.index') }}" class="ml-2 text-gray-600">Batal</a>
</form>
@endsection
