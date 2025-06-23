<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
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
        $mentor = Auth::user();
        $query = Announcement::where('user_id', $mentor->id)
                                ->with('user'); // Eager load the user who created the announcement

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $announcements = $query->latest()->paginate(10);

        return view('mentor.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mentor = Auth::user();
        // The mentor's major is implicitly assigned, no need to pass it explicitly to the view if not used for selection
        return view('mentor.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mentor = Auth::user();

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:published_at',
        ]);

        $announcement = Announcement::create([
            'user_id' => $mentor->id,
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'target_audience' => 'santri', // Always 'santri' for mentors
            'major_id' => $mentor->major_id, // Automatically assign mentor's major
            'published_at' => $validatedData['published_at'] ?? now(),
            'expires_at' => $validatedData['expires_at'] ?? null,
        ]);

        // Dispatch notification to santri in the same major
        $santriRole = Role::where('name', 'Santri')->first();
        $usersToNotify = User::where('role_id', $santriRole->id)
                              ->where('major_id', $mentor->major_id)
                              ->get();

        foreach ($usersToNotify as $user) {
            $user->notify(new NewAnnouncement($announcement));
        }

        return redirect()->route('mentor.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan dan dikirim ke santri di jurusan Anda.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        // Ensure mentor can only view their own announcements
        if ($announcement->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $announcement->load('user', 'major');
        return view('mentor.announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        // Ensure mentor can only edit their own announcements
        if ($announcement->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('mentor.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        // Ensure mentor can only update their own announcements
        if ($announcement->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:published_at',
        ]);

        // Delete existing notifications for this announcement
        \Illuminate\Notifications\DatabaseNotification::where('type', 'App\\Notifications\\NewAnnouncement')
            ->whereJsonContains('data->announcement_id', $announcement->id)
            ->delete();

        $announcement->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'published_at' => $validatedData['published_at'] ?? now(),
            'expires_at' => $validatedData['expires_at'] ?? null,
        ]);

        // Re-dispatch notification to santri in the same major
        $mentor = Auth::user();
        $santriRole = Role::where('name', 'Santri')->first();
        $usersToNotify = User::where('role_id', $santriRole->id)
                              ->where('major_id', $mentor->major_id)
                              ->get();

        foreach ($usersToNotify as $user) {
            $user->notify(new NewAnnouncement($announcement));
        }

        return redirect()->route('mentor.announcements.index')->with('success', 'Pengumuman berhasil diperbarui dan notifikasi dikirim ulang.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        // Ensure mentor can only delete their own announcements
        if ($announcement->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete existing notifications for this announcement
        \Illuminate\Notifications\DatabaseNotification::where('type', 'App\\Notifications\\NewAnnouncement')
            ->whereJsonContains('data->announcement_id', $announcement->id)
            ->delete();

        $announcement->delete();
        return redirect()->route('mentor.announcements.index')->with('success', 'Pengumuman berhasil dihapus dan notifikasi terkait juga dihapus.');
    }
}
