<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewUserRegistered extends Notification
{
    use Queueable;

    protected $newUser;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $newUser)
    {
        $this->newUser = $newUser;
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
    public function toArray(object $notifiable): array
    {
        $roleName = $this->newUser->role ? $this->newUser->role->name : 'Unknown';
        $message = "Pengguna baru '" . $this->newUser->name . "' dengan peran '" . $roleName . "' telah ditambahkan.";

        return [
            'title' => 'Pengguna Baru Terdaftar',
            'message' => $message,
            'user_id' => $this->newUser->id,
            'user_name' => $this->newUser->name,
            'user_role' => $roleName,
            'link' => route('admin.users.index'),
        ];
    }
}
