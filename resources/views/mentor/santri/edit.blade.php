@extends('mentor.layout')

@section('title', 'Edit Santri')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Edit Santri</h2>

    <div class="mt-4 bg-white p-6 rounded shadow">
        <form action="{{ route('mentor.santri.update', $santri->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('username') border-red-500 @enderror" value="{{ old('username', $santri->username) }}" required>
                @error('username')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name', $santri->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password (isi jika ingin ganti):</label>
                <div class="relative" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" name="password" id="mentorSantriEditPassword" class="shadow appearance-none border rounded w-full py-2 px-3 pr-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">
                    <i class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500" @click="show = !show" :class="{'fa fa-eye': !show, 'fa fa-eye-slash': show}"></i>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="major" class="block text-gray-700 text-sm font-bold mb-2">Jurusan:</label>
                <input type="text" id="major" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $santri->major->name ?? 'N/A' }}" disabled>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Santri
                </button>
                <a href="{{ route('mentor.santri.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
