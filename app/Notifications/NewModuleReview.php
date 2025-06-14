<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ModuleReview;

class NewModuleReview extends Notification
{
    use Queueable;

    protected $review;
    protected $moduleName;
    protected $reviewerName;
    protected $moduleLink;

    /**
     * Create a new notification instance.
     */
    public function __construct(ModuleReview $review, $moduleName, $reviewerName, $moduleLink)
    {
        $this->review = $review;
        $this->moduleName = $moduleName;
        $this->reviewerName = $reviewerName;
        $this->moduleLink = $moduleLink;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Menggunakan channel database
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Ulasan Modul Baru',
            'message' => 'Ada ulasan baru untuk modul Anda: "' . $this->moduleName . '". Ulasan diberikan oleh ' . $this->reviewerName . '.',
            'module_name' => $this->moduleName,
            'reviewer_name' => $this->reviewerName,
            'review_comment' => $this->review->comment,
            'rating' => $this->review->rating,
            'link' => $this->moduleLink,
        ];
    }
}
