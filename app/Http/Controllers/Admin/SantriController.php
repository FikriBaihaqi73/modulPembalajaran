<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;

class SantriController extends Controller
{
    public function index()
    {
        $santriRole = Role::where('name', 'Santri')->first();
        $santri = $santriRole ? $santriRole->users : collect();
        return view('admin.santri', compact('santri'));
    }

    public function create()
    {
        return view('admin.santri-create');
    }

    public function store(Request $request)
    {
        $santriRole = Role::where('name', 'Santri')->first();
        $data = $request->validate([
            'username' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required|min:6',
        ]);
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = $santriRole->id;
        User::create($data);
        return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $santri = User::where('role_id', Role::where('name', 'Santri')->first()->id)->findOrFail($id);
        return view('admin.santri-edit', compact('santri'));
    }

    public function update(Request $request, $id)
    {
        $santri = User::where('role_id', Role::where('name', 'Santri')->first()->id)->findOrFail($id);
        $data = $request->validate([
            'username' => 'required|unique:users,username,'.$santri->id,
            'name' => 'required',
            'password' => 'nullable|min:6',
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
