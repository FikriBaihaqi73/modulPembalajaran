<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mentor = Auth::user();
        $santriRole = Role::where('name', 'Santri')->first();
        $santri = User::where('role_id', $santriRole->id)
                        ->where('major_id', $mentor->major_id)
                        ->with('major')
                        ->get();
        return view('mentor.santri.index', compact('santri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mentor = Auth::user();
        // Ensure the mentor's major is available for the santri creation form, though it will be auto-assigned
        return view('mentor.santri.create', ['major' => $mentor->major]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mentor = Auth::user();
        $santriRole = Role::where('name', 'Santri')->first();

        $request->validate([
            'username' => 'required|unique:users,username|max:255',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'role_id' => $santriRole->id,
            'major_id' => $mentor->major_id, // Auto-assign mentor's major
        ]);

        return redirect()->route('mentor.santri.index')->with('success', 'Santri berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not used for this CRUD
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mentor = Auth::user();
        $santriRole = Role::where('name', 'Santri')->first();
        $santri = User::where('role_id', $santriRole->id)
                        ->where('major_id', $mentor->major_id)
                        ->findOrFail($id);
        return view('mentor.santri.edit', compact('santri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mentor = Auth::user();
        $santriRole = Role::where('name', 'Santri')->first();
        $santri = User::where('role_id', $santriRole->id)
                        ->where('major_id', $mentor->major_id)
                        ->findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,'.$santri->id.'|max:255',
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'username' => $request->username,
            'name' => $request->name,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $santri->update($data);

        return redirect()->route('mentor.santri.index')->with('success', 'Data santri berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mentor = Auth::user();
        $santriRole = Role::where('name', 'Santri')->first();
        $santri = User::where('role_id', $santriRole->id)
                        ->where('major_id', $mentor->major_id)
                        ->findOrFail($id);
        $santri->delete();

        return redirect()->route('mentor.santri.index')->with('success', 'Santri berhasil dihapus.');
    }
}
