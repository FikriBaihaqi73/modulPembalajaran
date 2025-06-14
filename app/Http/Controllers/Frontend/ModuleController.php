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
        $module = Module::with(['major', 'moduleCategory', 'reviews.user', 'reviews.replies.user'])
                        ->where('is_visible', true)
                        ->findOrFail($id);

        $userReview = null;
        if (Auth::check()) {
            $userReview = $module->reviews->where('user_id', Auth::id())->first();
        }

        return view('santri.modules.show', compact('module', 'userReview'));
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
        ModuleReview::create([
            'user_id' => $user->id,
            'module_id' => $module->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

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
