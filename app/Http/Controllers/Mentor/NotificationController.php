<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10);
        $unreadNotificationsCount = $user->unreadNotifications->count();

        return view('mentor.notifications.index', compact('notifications', 'unreadNotificationsCount'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect()->back()->with('success', 'Notifikasi berhasil ditandai sebagai sudah dibaca.');
        }

        return redirect()->back()->with('error', 'Notifikasi tidak ditemukan.');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'Semua notifikasi berhasil ditandai sebagai sudah dibaca.');
    }

    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
            return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Notifikasi tidak ditemukan.');
    }

    public function markAsUnread($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification && $notification->read_at) {
            $notification->markAsUnread();
            return redirect()->back()->with('success', 'Notifikasi berhasil ditandai sebagai belum dibaca.');
        }

        return redirect()->back()->with('error', 'Notifikasi tidak ditemukan atau sudah belum dibaca.');
    }
}
