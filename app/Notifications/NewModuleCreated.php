<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Module;

class NewModuleCreated extends Notification
{
    use Queueable;

    protected $module;
    protected $moduleLink;
    protected $isUpdate;

    /**
     * Create a new notification instance.
     */
    public function __construct(Module $module, $moduleLink, bool $isUpdate = false)
    {
        $this->module = $module;
        $this->moduleLink = $moduleLink;
        $this->isUpdate = $isUpdate;
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
        if ($this->isUpdate) {
            $title = 'Modul Diperbarui!';
            $message = 'Modul "' . $this->module->name . '" telah diubah di jurusan Anda.';
        } else {
            $title = 'Modul Baru Tersedia!';
            $message = 'Modul baru berjudul "' . $this->module->name . '" telah tersedia di jurusan Anda.';
        }

        return [
            'title' => $title,
            'message' => $message,
            'module_name' => $this->module->name,
            'link' => $this->moduleLink,
            'module_id' => $this->module->id,
        ];
    }
}