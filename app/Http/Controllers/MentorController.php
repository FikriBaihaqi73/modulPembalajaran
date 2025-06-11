<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class MentorController extends Controller
{
    public function index()
    {
        $mentorRole = Role::where('name', 'Mentor')->first();
        $mentor = $mentorRole ? $mentorRole->users : collect();
        return view('admin.mentor', compact('mentor'));
    }

    public function create()
    {
        return view('admin.mentor-create');
    }

    public function store(Request $request)
    {
        $mentorRole = Role::where('name', 'Mentor')->first();
        $data = $request->validate([
            'username' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required|min:6',
        ]);
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = $mentorRole->id;
        User::create($data);
        return redirect()->route('mentor.index')->with('success', 'Mentor berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mentor = User::where('role_id', Role::where('name', 'Mentor')->first()->id)->findOrFail($id);
        return view('admin.mentor-edit', compact('mentor'));
    }

    public function update(Request $request, $id)
    {
        $mentor = User::where('role_id', Role::where('name', 'Mentor')->first()->id)->findOrFail($id);
        $data = $request->validate([
            'username' => 'required|unique:users,username,'.$mentor->id,
            'name' => 'required',
            'password' => 'nullable|min:6',
        ]);
        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $mentor->update($data);
        return redirect()->route('mentor.index')->with('success', 'Mentor berhasil diupdate.');
    }

    public function destroy($id)
    {
        $mentor = User::where('role_id', Role::where('name', 'Mentor')->first()->id)->findOrFail($id);
        $mentor->delete();
        return redirect()->route('mentor.index')->with('success', 'Mentor berhasil dihapus.');
    }
}
