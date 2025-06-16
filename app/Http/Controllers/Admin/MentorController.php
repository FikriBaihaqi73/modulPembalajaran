<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Major;
use App\Http\Controllers\Controller;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $mentorRole = Role::where('name', 'Mentor')->first();
        $query = User::where('role_id', $mentorRole->id)->with('major');

        // Apply search filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        // Apply major filter
        if ($request->has('major_id') && $request->input('major_id') != '') {
            $majorId = $request->input('major_id');
            $query->where('major_id', $majorId);
        }

        $mentor = $query->latest()->paginate(10);
        $majors = Major::all(); // Get all majors for the filter dropdown

        return view('admin.mentor.index', compact('mentor', 'majors'));
    }

    public function create()
    {
        $majors = Major::all();
        return view('admin.mentor.create', compact('majors'));
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
        return view('admin.mentor.edit', compact('mentor', 'majors'));
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
