@extends('admin.layout')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Admin Profile</h2>

    <div class="mt-4 bg-white p-6 rounded shadow mb-6">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Profile Information</h3>

        <form action="{{ route('admin.profile.updateDetails') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name:
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Username:
                </label>
                <input type="text" id="username" name="username" value="{{ old('username', Auth::user()->username) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @error('username')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Profile</button>
        </form>
    </div>

    <div class="mt-4 bg-white p-6 rounded shadow">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Change Password</h3>

        <form action="{{ route('admin.profile.updatePassword') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="current_password">
                    Current Password:
                </label>
                <input type="password" id="current_password" name="current_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @error('current_password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    New Password:
                </label>
                <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                    Confirm New Password:
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Change Password</button>
        </form>
    </div>
@endsection
