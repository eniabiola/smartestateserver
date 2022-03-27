<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class AdminActivateResident extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $name;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->name = $this->user->surname." ".$this->user->othernames;
        $this->message = "New Resident ($this->name) Alert: Login to Activate";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\DatabaseNotification
     */
    public function toDatabase($notifiable)
    {
        return [
//            'resident_id' => $this->user->id,
//            'resident_name' => $this->name,
            'message' => $this->message
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->id,
            'read_at' => null,
            'data' => [
//                'resident_id' => $this->user->id,
//                'resident_name' => $this->name,
                'message' => $this->message
            ],
        ];
    }
}
