@extends('admin.layout')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Admin Profile</h2>
        <p class="mt-1 text-gray-600">Kelola informasi profil dan pengaturan akun Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">Informasi Admin</h3>
                <p class="mt-1 text-sm text-gray-500">Detail informasi akun dan profil admin.</p>
            </div>
            <div class="px-4 py-5 sm:p-6 space-y-6">
                <div>
                    <div class="flex items-center justify-center mb-6">
                        <div class="h-24 w-24 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <h4 class="text-lg font-medium text-gray-900">{{ Auth::user()->name }}</h4>
                        <p class="text-sm text-gray-500">@<span>{{ Auth::user()->username }}</span></p>
                    </div>

                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Status:</dt>
                            <dd class="text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Peran:</dt>
                            <dd class="text-sm text-gray-900">Administrator</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Forms Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Update Profile Form -->
            <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-200">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Perbarui Detail Profil</h3>
                    <p class="mt-1 text-sm text-gray-500">Ubah nama dan username akun Anda.</p>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('admin.profile.updateDetails') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">@</span>
                                <input type="text" name="username" id="username" value="{{ old('username', Auth::user()->username) }}" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300" required>
                            </div>
                            @error('username')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password Form -->
            <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-200">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Perbarui Password</h3>
                    <p class="mt-1 text-sm text-gray-500">Pastikan menggunakan password yang kuat dan mudah diingat.</p>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('admin.profile.updatePassword') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            @error('current_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <input type="password" name="password" id="password" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
