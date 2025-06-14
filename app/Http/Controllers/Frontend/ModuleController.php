<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\ModuleCategory;
use App\Models\Major;
use App\Models\ModuleProgress;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = false;
        $majors = collect();

        if (Auth::check()) {
            if (Auth::user()->role->name === 'Admin') {
                $isAdmin = true;
                $majors = Major::all();
            }
        } else {
            return view('santri.modules.guest_index');
        }

        $query = Module::with(['major', 'moduleCategory'])->where('is_visible', true);

        // Apply search filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Apply module category filter (single select for frontend for simplicity)
        if ($request->has('module_category_id') && $request->input('module_category_id') != '') {
            $categoryId = $request->input('module_category_id');
            $query->whereHas('moduleCategory', function ($q) use ($categoryId) {
                $q->where('module_categories.id', $categoryId);
            });
        }

        // Apply major filter if user is admin and major_id is provided
        if ($isAdmin && $request->has('major_id') && $request->input('major_id') != '') {
            $majorId = $request->input('major_id');
            $query->where('major_id', $majorId);
        }

        $modules = $query->paginate(12);
        $moduleCategories = ModuleCategory::all();

        return view('santri.modules.index', compact('modules', 'moduleCategories', 'isAdmin', 'majors'));
    }

    /**
     * Display the specified module for santri.
     */
    public function show(string $id)
    {
        // Ensure the module is visible and exists
        $module = Module::with(['major', 'moduleCategory'])
                        ->where('is_visible', true)
                        ->findOrFail($id);

        return view('santri.modules.show', compact('module'));
    }

    /**
     * Toggle the completion status of a module for the authenticated user.
     */
    public function toggleCompletion(Request $request, Module $module)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login untuk menandai modul.');
        }

        $user = Auth::user();

        $progress = ModuleProgress::firstOrCreate(
            ['user_id' => $user->id, 'module_id' => $module->id],
            ['is_completed' => false] // Default to false if not exists
        );

        $progress->is_completed = !$progress->is_completed;
        $progress->save();

        $statusMessage = $progress->is_completed ? 'selesai' : 'belum selesai';
        return redirect()->back()->with('success', 'Modul berhasil ditandai sebagai ' . $statusMessage . '.');
    }
}
