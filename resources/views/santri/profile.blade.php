@extends('santri.layouts.app')

@section('title', 'Profil Santri')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <header class="mb-10">
            <h2 class="text-3xl font-bold text-gray-900">Profil Santri</h2>
            <p class="mt-2 text-gray-600">Kelola informasi pribadi dan pengaturan akun Anda</p>
        </header>

        {{-- Alerts Section --}}
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0 pt-0.5">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terdapat beberapa masalah:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Profile Card --}}
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Santri</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Detail informasi akun dan profil Anda.</p>
                </div>
                <div class="px-4 py-5 sm:p-6 space-y-6">
                    <div>
                        <div class="flex items-center justify-center mb-6">
                            <div class="h-24 w-24 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>

                        <div class="text-center mb-6">
                            <h4 class="text-lg font-medium text-gray-900">{{ $user->name }}</h4>
                            <p class="text-sm text-gray-500">@<span>{{ $user->username }}</span></p>
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
                                <dd class="text-sm text-gray-900">{{ $user->role->name ?? 'N/A' }}</dd>
                            </div>
                            @if($user->major)
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Jurusan:</dt>
                                    <dd class="text-sm text-gray-900">{{ $user->major->name }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Forms Column --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Update Profile Form --}}
                <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Perbarui Detail Profil</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Ubah nama dan username akun Anda.</p>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <form action="{{ route('santri.profile.updateDetails') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                        class="shadow-sm block w-full sm:text-sm rounded-md {{ $errors->has('name') ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}">
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <div class="mt-1">
                                    <div class="flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                            @
                                        </span>
                                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required
                                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md sm:text-sm {{ $errors->has('username') ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}">
                                    </div>
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

                {{-- Update Password Form --}}
                <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Perbarui Password</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Pastikan menggunakan password yang kuat dan mudah diingat.</p>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <form action="{{ route('santri.profile.updatePassword') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                                <div class="mt-1">
                                    <input type="password" name="current_password" id="current_password" required
                                        class="shadow-sm block w-full sm:text-sm rounded-md {{ $errors->has('current_password') ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}">
                                </div>
                                @error('current_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <div class="mt-1">
                                    <input type="password" name="new_password" id="new_password" required
                                        class="shadow-sm block w-full sm:text-sm rounded-md {{ $errors->has('new_password') ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}">
                                </div>
                                @error('new_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                <div class="mt-1">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
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
    </div>
@endsection
