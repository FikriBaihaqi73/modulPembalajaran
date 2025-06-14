<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class ModuleProgressController extends Controller
{
    public function index()
    {
        $mentorId = Auth::id();

        $modules = Module::where('user_id', $mentorId)
                            ->with(['progress.user', 'reviews', 'reviews.user'])
                            ->get();

        return view('mentor.module_progress.index', compact('modules'));
    }

    public function show(Module $module)
    {
        // Ensure the module belongs to the authenticated mentor
        if ($module->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $module->load(['progress.user', 'user', 'major', 'reviews.user']);

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
