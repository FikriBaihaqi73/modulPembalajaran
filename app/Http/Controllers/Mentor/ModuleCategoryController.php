<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModuleCategory;
use Illuminate\Support\Facades\Auth;

class ModuleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mentor = Auth::user();
        $moduleCategories = ModuleCategory::where('major_id', $mentor->major_id)->paginate(10);
        return view('mentor.module_categories.index', compact('moduleCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mentor.module_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mentor = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255',
                function ($attribute, $value, $fail) use ($mentor) {
                    if (ModuleCategory::where('major_id', $mentor->major_id)->where('name', $value)->exists()) {
                        $fail('Kategori modul dengan nama ini sudah ada untuk jurusan Anda.');
                    }
                },
            ],
        ]);

        ModuleCategory::create([
            'name' => $request->name,
            'major_id' => $mentor->major_id,
        ]);

        return redirect()->route('mentor.module-categories.index')->with('success', 'Kategori modul berhasil ditambahkan.');
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
        $moduleCategory = ModuleCategory::where('major_id', $mentor->major_id)->findOrFail($id);
        return view('mentor.module_categories.edit', compact('moduleCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mentor = Auth::user();
        $moduleCategory = ModuleCategory::where('major_id', $mentor->major_id)->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255',
                function ($attribute, $value, $fail) use ($mentor, $moduleCategory) {
                    if (ModuleCategory::where('major_id', $mentor->major_id)
                                       ->where('name', $value)
                                       ->where('id', '!=', $moduleCategory->id)
                                       ->exists()) {
                        $fail('Kategori modul dengan nama ini sudah ada untuk jurusan Anda.');
                    }
                },
            ],
        ]);

        $moduleCategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('mentor.module-categories.index')->with('success', 'Kategori modul berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mentor = Auth::user();
        $moduleCategory = ModuleCategory::where('major_id', $mentor->major_id)->findOrFail($id);
        $moduleCategory->delete();

        return redirect()->route('mentor.module-categories.index')->with('success', 'Kategori modul berhasil dihapus.');
    }
}
