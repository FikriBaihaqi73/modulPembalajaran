@extends('admin.layout')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Pengguna</h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="name" class="block mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="username" class="block mb-1">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="w-full border rounded px-3 py-2 @error('username') border-red-500 @enderror" required>
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block mb-1">Password (Biarkan kosong jika tidak ingin mengubah)</label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password" id="adminUserEditPassword" class="w-full border rounded px-3 py-2 pr-10 @error('password') border-red-500 @enderror">
                        <i class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500" @click="show = !show" :class="{'fa fa-eye': !show, 'fa fa-eye-slash': show}"></i>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-1">Konfirmasi Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" id="adminUserEditPasswordConfirmation" class="w-full border rounded px-3 py-2 pr-10 @error('password_confirmation') border-red-500 @enderror">
                        <i class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500" @click="show = !show" :class="{'fa fa-eye': !show, 'fa fa-eye-slash': show}"></i>
                    </div>
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role_id" class="block mb-1">Peran</label>
                    <select name="role_id" id="role_id" class="w-full border rounded px-3 py-2 @error('role_id') border-red-500 @enderror" required>
                        <option value="">Pilih Peran</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ (old('role_id', $user->role_id) == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="major-field" style="display: {{ (old('role_id', $user->role_id) && in_array(App\Models\Role::find(old('role_id', $user->role_id))->name ?? '', ['Mentor', 'Santri'])) ? 'block' : 'none' }};">
                    <label for="major_id" class="block mb-1">Jurusan</label>
                    <select name="major_id" id="major_id" class="w-full border rounded px-3 py-2 @error('major_id') border-red-500 @enderror">
                        <option value="">Pilih Jurusan</option>
                        @foreach($majors as $major)
                            <option value="{{ $major->id }}" {{ (old('major_id', $user->major_id) == $major->id) ? 'selected' : '' }}>{{ $major->name }}</option>
                        @endforeach
                    </select>
                    @error('major_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="ml-2 text-gray-600">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Perbarui Pengguna
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role_id');
            const majorField = document.getElementById('major-field');
            const majorSelect = document.getElementById('major_id');

            const rolesNeedingMajor = ['Mentor', 'Santri']; // Names of roles that require a major
            const allRoles = @json($roles->pluck('name', 'id')); // Map role IDs to names

            function toggleMajorField() {
                const selectedRoleId = roleSelect.value;
                const selectedRoleName = allRoles[selectedRoleId];

                if (rolesNeedingMajor.includes(selectedRoleName)) {
                    majorField.style.display = 'block';
                    majorSelect.setAttribute('required', 'required');
                } else {
                    majorField.style.display = 'none';
                    majorSelect.removeAttribute('required');
                    majorSelect.value = ''; // Clear selection if major is not needed
                }
            }

            roleSelect.addEventListener('change', toggleMajorField);

            // Initial call to set visibility based on old input or current user's role
            toggleMajorField();
        });
    </script>
@endsection
