<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Major;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Announcement::with('user', 'major');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('target_audience') && $request->target_audience != '') {
            $query->where('target_audience', $request->target_audience);
        }

        if ($request->has('major_id') && $request->major_id != '') {
            $query->where('major_id', $request->major_id);
        }

        $announcements = $query->latest()->paginate(10);
        $majors = Major::all();
        $roles = Role::all(); // For target audience filter if needed

        return view('admin.announcements.index', compact('announcements', 'majors', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = Major::all();
        return view('admin.announcements.create', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|in:all,santri,mentor',
            'major_id' => 'nullable|exists:majors,id',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:published_at',
        ]);

        $announcement = Announcement::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'target_audience' => $validatedData['target_audience'],
            'major_id' => $validatedData['major_id'] ?? null,
            'published_at' => $validatedData['published_at'] ?? now(),
            'expires_at' => $validatedData['expires_at'] ?? null,
        ]);

        // Dispatch notification
        if ($announcement->target_audience === 'all') {
            $usersToNotify = User::all();
        } elseif ($announcement->target_audience === 'santri') {
            $santriRole = Role::where('name', 'Santri')->first();
            $usersToNotify = User::where('role_id', $santriRole->id);
            if ($announcement->major_id) {
                $usersToNotify->where('major_id', $announcement->major_id);
            }
            $usersToNotify = $usersToNotify->get();
        } elseif ($announcement->target_audience === 'mentor') {
            $mentorRole = Role::where('name', 'Mentor')->first();
            $usersToNotify = User::where('role_id', $mentorRole->id);
            if ($announcement->major_id) {
                $usersToNotify->where('major_id', $announcement->major_id);
            }
            $usersToNotify = $usersToNotify->get();
        } else {
            $usersToNotify = collect(); // No one to notify
        }

        foreach ($usersToNotify as $user) {
            $user->notify(new NewAnnouncement($announcement));
        }

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan dan dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        $majors = Major::all();
        return view('admin.announcements.edit', compact('announcement', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|in:all,santri,mentor',
            'major_id' => 'nullable|exists:majors,id',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:published_at',
        ]);

        $announcement->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'target_audience' => $validatedData['target_audience'],
            'major_id' => $validatedData['major_id'] ?? null,
            'published_at' => $validatedData['published_at'] ?? now(),
            'expires_at' => $validatedData['expires_at'] ?? null,
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
