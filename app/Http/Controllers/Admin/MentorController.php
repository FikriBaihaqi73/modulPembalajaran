<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Major;
use App\Http\Controllers\Controller;

class MentorController extends Controller
{
    public function index()
    {
        $mentorRole = Role::where('name', 'Mentor')->first();
        $mentor = $mentorRole ? User::where('role_id', $mentorRole->id)->with('major')->get() : collect();
        return view('admin.mentor', compact('mentor'));
    }

    public function create()
    {
        $majors = Major::all();
        return view('admin.mentor-create', compact('majors'));
    }

    public function store(Request $request)
    {
        $mentorRole = Role::where('name', 'Mentor')->first();
        $data = $request->validate([
            'username' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required|min:6',
            'major_id' => 'required|exists:majors,id',
        ]);
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = $mentorRole->id;
        User::create($data);
        return redirect()->route('admin.mentor.index')->with('success', 'Mentor berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mentor = User::where('role_id', Role::where('name', 'Mentor')->first()->id)->with('major')->findOrFail($id);
        $majors = Major::all();
        return view('admin.mentor-edit', compact('mentor', 'majors'));
    }

    public function update(Request $request, $id)
    {
        $mentor = User::where('role_id', Role::where('name', 'Mentor')->first()->id)->findOrFail($id);
        $data = $request->validate([
            'username' => 'required|unique:users,username,'.$mentor->id,
            'name' => 'required',
            'password' => 'nullable|min:6',
            'major_id' => 'required|exists:majors,id',
        ]);
        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $mentor->update($data);
        return redirect()->route('admin.mentor.index')->with('success', 'Mentor berhasil diupdate.');
    }

    public function destroy($id)
    {
        $mentor = User::where('role_id', Role::where('name', 'Mentor')->first()->id)->findOrFail($id);
        $mentor->delete();
        return redirect()->route('admin.mentor.index')->with('success', 'Mentor berhasil dihapus.');
    }
}
