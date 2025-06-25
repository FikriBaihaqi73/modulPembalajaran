<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\ModuleCategory;
use App\Models\Major;
use App\Models\ModuleProgress;
use App\Models\ModuleReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = false;
        $majors = collect();
        $query = Module::visibleForSantri(); // Use the new scope
        $moduleCategoriesQuery = ModuleCategory::where('is_visible', true); // Categories still filtered by their own visibility

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role->name === 'Admin') {
                $isAdmin = true;
                $majors = Major::all();
                // Admin bisa melihat semua modul dan kategori secara default, tanpa filter is_visible atau scope santri
                $query = Module::with(['major', 'moduleCategory']);
                $moduleCategoriesQuery = ModuleCategory::query();
            } else {
                // Non-admin (Santri), filter modul berdasarkan major_id user yang login
                $query->where('major_id', $user->major_id);
                // Non-admin (Santri), filter kategori berdasarkan major_id user yang login
                $moduleCategoriesQuery->where('major_id', $user->major_id);
            }
        } else {
            // Jika tidak login, hanya tampilkan modul yang visibleForSantri
            // Module::visibleForSantri() already applied above
            return view('santri.modules.guest_index');
        }

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
                $q->where('module_categories.id', $categoryId); // No need to check is_visible here, as the parent query already ensures this via scope/initial filter
            });
        }

        // Apply major filter only if user is admin AND major_id is provided in request
        if ($isAdmin && $request->has('major_id') && $request->input('major_id') != '') {
            $majorId = $request->input('major_id');
            $query->where('major_id', $majorId);
            // Jika admin memfilter berdasarkan major_id, kategori juga harus difilter
            $moduleCategoriesQuery->where('major_id', $majorId);
        }

        $modules = $query->latest()->paginate(12);
        $moduleCategories = $moduleCategoriesQuery->get(); // Ambil kategori yang sudah difilter

        return view('santri.modules.index', compact('modules', 'moduleCategories', 'isAdmin', 'majors'));
    }

    /**
     * Display the specified module for santri.
     */
    public function show(string $id)
    {
        $moduleQuery = Module::with(['major', 'moduleCategory', 'reviews.user', 'reviews.replies.user']);

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role->name === 'Santri') {
                $moduleQuery->where('major_id', $user->major_id)->visibleForSantri(); // Apply scope for Santri
            } else if ($user->role->name === 'Admin') {
                // Admin dapat melihat semua modul tanpa filter major_id atau is_visible
                // No additional filters needed for Admin
            }
        } else {
            // Jika tidak login, hanya tampilkan modul yang visibleForSantri
            $moduleQuery->visibleForSantri();
        }

        $module = $moduleQuery->findOrFail($id);

        $userReview = null;
        if (Auth::check()) {
            $userReview = $module->reviews->where('user_id', Auth::id())->first();
        }

        return view('santri.modules.show', compact('module', 'userReview'));
    }

    /**
     * Display modules completed by the authenticated santri.
     */
    public function completedModules(Request $request)
    {
        if (!Auth::check() || Auth::user()->role->name !== 'Santri') {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai Santri untuk mengakses halaman ini.');
        }

        $user = Auth::user();

        $query = Module::visibleForSantri() // Use the new scope
                        ->where('major_id', $user->major_id)
                        ->whereHas('progress', function ($q) use ($user) {
                            $q->where('user_id', $user->id)
                              ->where('is_completed', true);
                        });

        $moduleCategoriesQuery = ModuleCategory::where('major_id', $user->major_id)->where('is_visible', true); // Categories relevant to the santri's major and visible

        // Apply search filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Apply module category filter
        if ($request->has('module_category_id') && $request->input('module_category_id') != '') {
            $categoryId = $request->input('module_category_id');
            $query->whereHas('moduleCategory', function ($q) use ($categoryId) {
                $q->where('module_categories.id', $categoryId);
            });
        }

        $modules = $query->latest()->paginate(12);
        $moduleCategories = $moduleCategoriesQuery->get();

        $isAdmin = false; // For the view compatibility, as this is santri specific
        $majors = collect(); // For the view compatibility, as this is santri specific

        // Get total modules for the user's major (only visible ones)
        $totalModules = Module::visibleForSantri()->where('major_id', $user->major_id)->count();

        // Get completed modules count (already fetched by $modules query)
        $completedModulesCount = $query->count();

        // Get uncompleted modules count (only visible ones)
        $uncompletedModulesCount = Module::visibleForSantri()->where('major_id', $user->major_id)
            ->whereDoesntHave('progress', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->where('is_completed', true);
            })
            ->count();

        return view('santri.modules.completed_index', compact('modules', 'moduleCategories', 'isAdmin', 'majors', 'totalModules', 'completedModulesCount', 'uncompletedModulesCount'));
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

    /**
     * Store a new module review.
     */
    public function storeReview(Request $request, Module $module)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login untuk memberikan ulasan.');
        }

        $user = Auth::user();

        // Validate the request
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        // Check if the user has already reviewed this module
        $existingReview = ModuleReview::where('user_id', $user->id)
                                        ->where('module_id', $module->id)
                                        ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk modul ini.');
        }

        // Create and save the review
        $review = ModuleReview::create([
            'user_id' => $user->id,
            'module_id' => $module->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Notify the mentor (module creator)
        $mentor = $module->user; // Assuming module has a 'user' relationship to its creator
        if ($mentor) {
            $moduleLink = route('santri.modules.show', $module->id);
            $mentor->notify(new \App\Notifications\NewModuleReview($review, $module->name, $user->name, $moduleLink));
        }

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dikirim!');
    }

    /**
     * Update the specified module review.
     */
    public function updateReview(Request $request, Module $module, ModuleReview $review)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login untuk memperbarui ulasan.');
        }

        $user = Auth::user();

        // Ensure the authenticated user owns this review
        if ($review->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan untuk memperbarui ulasan ini.');
        }

        // Validate the request
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        // Update the review
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()->back()->with('success', 'Ulasan Anda berhasil diperbarui!');
    }

    /**
     * Remove the specified module review from storage.
     */
    public function destroyReview(Module $module, ModuleReview $review)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login untuk menghapus ulasan.');
        }

        $user = Auth::user();

        // Ensure the authenticated user owns this review
        if ($review->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan untuk menghapus ulasan ini.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dihapus!');
    }
}
