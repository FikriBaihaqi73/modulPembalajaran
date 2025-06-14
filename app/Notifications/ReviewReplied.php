<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ReviewReply;

class ReviewReplied extends Notification
{
    use Queueable;

    protected $reply;

    /**
     * Create a new notification instance.
     */
    public function __construct(ReviewReply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'review_id' => $this->reply->review->id,
            'module_id' => $this->reply->review->module->id,
            'module_name' => $this->reply->review->module->name,
            'replier_name' => $this->reply->user->name ?? 'Mentor/Admin Tidak Dikenal',
            'reply_content' => $this->reply->reply_content,
            'review_comment' => $this->reply->review->comment,
            'link' => route('santri.modules.show', $this->reply->review->module->id),
        ];
    }
}
