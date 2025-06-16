<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Notifications\NewUserRegistered;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('role', 'major');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('role_id') && $request->role_id != '') {
            $query->where('role_id', $request->role_id);
        }

        if ($request->has('major_id') && $request->major_id != '') {
            $query->where('major_id', $request->major_id);
        }

        $users = $query->latest()->paginate(10);
        $roles = Role::all();
        $majors = Major::all();

        return view('admin.users.index', compact('users', 'roles', 'majors'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        $majors = Major::all();
        return view('admin.users.create', compact('roles', 'majors'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'major_id' => ['nullable', 'exists:majors,id', Rule::requiredIf(function () use ($request) {
                // Major is required if role is Mentor or Santri
                $role = Role::find($request->role_id);
                return $role && in_array($role->name, ['Mentor', 'Santri']);
            })],
        ]);

        $newUser = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => $validatedData['role_id'],
            'major_id' => $validatedData['major_id'],
        ]);

        // Notify all admins if the new user is a Mentor or Santri
        if ($newUser->role && in_array($newUser->role->name, ['Mentor', 'Santri'])) {
            $admins = User::whereHas('role', function ($query) {
                $query->where('name', 'Admin');
            })->get();

            foreach ($admins as $admin) {
                $admin->notify(new NewUserRegistered($newUser));
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $majors = Major::all();
        return view('admin.users.edit', compact('user', 'roles', 'majors'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'major_id' => ['nullable', 'exists:majors,id', Rule::requiredIf(function () use ($request) {
                $role = Role::find($request->role_id);
                return $role && in_array($role->name, ['Mentor', 'Santri']);
            })],
        ]);

        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->role_id = $validatedData['role_id'];
        $user->major_id = $validatedData['major_id'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
