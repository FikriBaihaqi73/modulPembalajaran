<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Major;
use App\Http\Controllers\Controller;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $santriRole = Role::where('name', 'Santri')->first();
        $query = User::where('role_id', $santriRole->id)->with('major');

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

        $santri = $query->latest()->paginate(10);
        $majors = Major::all(); // Get all majors for the filter dropdown

        return view('admin.santri.index', compact('santri', 'majors'));
    }

    public function create()
    {
        $majors = Major::all();
        return view('admin.santri.create', compact('majors'));
    }

    public function store(Request $request)
    {
        $santriRole = Role::where('name', 'Santri')->first();
        $data = $request->validate([
            'username' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required|min:6',
            'major_id' => 'required|exists:majors,id',
        ]);
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = $santriRole->id;
        User::create($data);
        return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $santri = User::where('role_id', Role::where('name', 'Santri')->first()->id)->with('major')->findOrFail($id);
        $majors = Major::all();
        return view('admin.santri.edit', compact('santri', 'majors'));
    }

    public function update(Request $request, $id)
    {
        $santri = User::where('role_id', Role::where('name', 'Santri')->first()->id)->findOrFail($id);
        $data = $request->validate([
            'username' => 'required|unique:users,username,'.$santri->id,
            'name' => 'required',
            'password' => 'nullable|min:6',
            'major_id' => 'required|exists:majors,id',
        ]);
        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $santri->update($data);
        return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil diupdate.');
    }

    public function destroy($id)
    {
        $santri = User::where('role_id', Role::where('name', 'Santri')->first()->id)->findOrFail($id);
        $santri->delete();
        return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil dihapus.');
    }
}
