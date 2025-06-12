<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mentor = Auth::user();
        $modules = Module::where('user_id', $mentor->id)->with(['major', 'moduleCategory'])->get();
        return view('mentor.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mentor = Auth::user();
        $moduleCategories = ModuleCategory::where('major_id', $mentor->major_id)->get();
        return view('mentor.modules.create', compact('moduleCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mentor = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'module_category_id' => ['required', 'exists:module_categories,id',
                function ($attribute, $value, $fail) use ($mentor) {
                    if (!ModuleCategory::where('id', $value)->where('major_id', $mentor->major_id)->exists()) {
                        $fail('Kategori modul yang dipilih tidak valid untuk jurusan Anda.');
                    }
                },
            ],
        ]);

        Module::create([
            'name' => $request->name,
            'content' => $request->content,
            'major_id' => $mentor->major_id,
            'module_category_id' => $request->module_category_id,
            'user_id' => $mentor->id,
        ]);

        return redirect()->route('mentor.modules.index')->with('success', 'Modul berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mentor = Auth::user();
        $module = Module::where('user_id', $mentor->id)->with(['major', 'moduleCategory'])->findOrFail($id);
        return view('mentor.modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mentor = Auth::user();
        $module = Module::where('user_id', $mentor->id)->findOrFail($id);
        $moduleCategories = ModuleCategory::where('major_id', $mentor->major_id)->get();
        return view('mentor.modules.edit', compact('module', 'moduleCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mentor = Auth::user();
        $module = Module::where('user_id', $mentor->id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'module_category_id' => ['required', 'exists:module_categories,id',
                function ($attribute, $value, $fail) use ($mentor) {
                    if (!ModuleCategory::where('id', $value)->where('major_id', $mentor->major_id)->exists()) {
                        $fail('Kategori modul yang dipilih tidak valid untuk jurusan Anda.');
                    }
                },
            ],
        ]);

        $module->update([
            'name' => $request->name,
            'content' => $request->content,
            'module_category_id' => $request->module_category_id,
        ]);

        return redirect()->route('mentor.modules.index')->with('success', 'Modul berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mentor = Auth::user();
        $module = Module::where('user_id', $mentor->id)->findOrFail($id);
        $module->delete();

        return redirect()->route('mentor.modules.index')->with('success', 'Modul berhasil dihapus.');
    }
}
