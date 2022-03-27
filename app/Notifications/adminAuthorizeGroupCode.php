<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class adminAuthorizeGroupCode extends Notification
{
    use Queueable;

    public $authorization_status;
    public $pass_code;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($authorization, $pass_code)
    {
        $this->authorization_status = $authorization;
        $this->pass_code = $pass_code;
        $this->message = "Visit Code Alert: Your Group visit code ".$this->pass_code." has been ".$this->authorization_status;
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return [
          "message" => $this->message
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
                'message' => $this->message,
            ],
        ];
    }
}
