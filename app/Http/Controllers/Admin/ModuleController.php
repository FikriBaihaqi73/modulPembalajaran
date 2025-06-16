<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Module::query();

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        // Apply major filter for Admin
        if ($request->has('major_id') && $request->major_id != '') {
            $query->where('major_id', $request->major_id);
        }

        $modules = $query->with('major', 'moduleCategory')->latest()->paginate(10);
        $majors = Major::all(); // Get all majors for the filter dropdown

        return view('admin.modules.index', compact('modules', 'majors'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        // Admin can view, but not necessarily edit/delete
        return view('admin.modules.show', compact('module'));
    }

    /**
     * No create, store, edit, update, destroy, or toggleVisibility for admin for simplicity
     */

}
