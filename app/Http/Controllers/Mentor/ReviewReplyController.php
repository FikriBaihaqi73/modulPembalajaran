<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModuleReview;
use App\Models\ReviewReply;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReviewReplied;

class ReviewReplyController extends Controller
{
    public function store(Request $request, ModuleReview $review)
    {
        // Ensure only authenticated users can reply
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login untuk membalas ulasan.');
        }

        // Validate the request
        $request->validate([
            'reply_content' => ['required', 'string', 'max:1000'],
        ]);

        // Create and save the reply
        $reply = ReviewReply::create([
            'review_id' => $review->id,
            'user_id' => Auth::id(), // The mentor/admin who is replying
            'reply_content' => $request->reply_content,
        ]);

        // Send notification to the review author (santri)
        $review->user->notify(new ReviewReplied($reply));

        return redirect()->back()->with('success', 'Balasan Anda berhasil dikirim!');
    }
}
