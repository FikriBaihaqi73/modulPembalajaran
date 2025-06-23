<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Module;

class ModuleDeleted extends Notification
{
    use Queueable;

    protected $moduleName;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $moduleName)
    {
        $this->moduleName = $moduleName;
    }

    /**
     * Get the notification\'s delivery channels.
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
        return [
            'title' => 'Modul Dihapus',
            'message' => 'Modul "' . $this->moduleName . '" telah dihapus dari daftar modul jurusan Anda.',
            'module_name' => $this->moduleName,
            'link' => null, // No specific link as the module is deleted
        ];
    }
}
