<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Support\Facades\Auth;

class ModuleProgressController extends Controller
{
    public function index(Request $request)
    {
        $mentor = Auth::user(); // Ambil objek user mentor
        $mentorId = $mentor->id;

        // Memastikan modul yang ditampilkan adalah milik mentor DAN sesuai dengan jurusannya
        $query = Module::where('user_id', $mentorId)
                            ->where('major_id', $mentor->major_id)
                            ->with(['progress.user', 'reviews', 'reviews.user']);

        // Apply search filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Apply category filter
        if ($request->has('category_id') && $request->input('category_id') != '') {
            $categoryId = $request->input('category_id');
            $query->whereHas('moduleCategory', function ($q) use ($categoryId) {
                $q->where('module_categories.id', $categoryId);
            });
        }

        $modules = $query->paginate(12);

        // Filter module categories based on the mentor's own major_id
        $moduleCategories = ModuleCategory::where('major_id', $mentor->major_id)->get();

        return view('mentor.module_progress.index', compact('modules', 'moduleCategories'));
    }

    public function show(Module $module)
    {
        // Ensure the module belongs to the authenticated mentor
        if ($module->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $module->load(['progress.user', 'user', 'major', 'reviews.user', 'reviews.replies.user']);

        $completedCount = $module->progress->where('is_completed', true)->count();
        $notCompletedCount = $module->progress->where('is_completed', false)->count();
        $totalTracking = $module->progress->count();

        $completionData = [
            'completed' => $completedCount,
            'not_completed' => $notCompletedCount,
            'total_tracking' => $totalTracking,
        ];

        return view('mentor.module_progress.show', compact('module', 'completionData'));
    }
}
