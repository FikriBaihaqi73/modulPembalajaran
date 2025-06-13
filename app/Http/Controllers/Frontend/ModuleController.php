<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
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

        $modules = $query->paginate(12); // Paginate for better performance
        $moduleCategories = ModuleCategory::all(); // Get all categories for filter dropdown

        return view('santri.modules.index', compact('modules', 'moduleCategories'));
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
}
