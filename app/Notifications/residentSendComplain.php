<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class residentSendComplain extends Notification implements ShouldQueue
{
    use Queueable;

    public $resident;
    public $user;
    public $name;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $title)
    {
        $this->user = $user;
        $this->title = $title;
        $this->name = $this->user->surname." ".$this->user->othernames;
        $this->message = $this->message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toDatabase($notifiable)
    {

        return [
            'resident_id' => $this->user->id,
            'resident_name' => $this->name,
            'message' => $this->message
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'id' => $this->id,
            'read_at' => null,
            'data' => [
                'resident_id' => $this->user->id,
                'resident_name' => $this->name,
                'message' => $this->message,
            ],
        ];
    }
}
