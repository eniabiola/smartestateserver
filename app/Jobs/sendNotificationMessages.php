<?php

namespace App\Jobs;

use App\Mail\GeneralMail;
use App\Models\Notification;
use App\Models\NotificationGroup;
use App\Models\Street;
use App\Models\User;
use App\Notifications\adminSendsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class sendNotificationMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notification_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notification_id)
    {
        $this->notification_id = $notification_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notification = Notification::query()
                        ->find($this->notification_id);

        $message = "New Message Alert: You have just receive a message from Estate Admin";
        switch ($notification->recipient_type)
        {
            case "user":
              $user = User::query()->find($notification->recipient_id);
                $this->sendNotification($user, $message);
                break;
            case "street":
                $users = Street::query()
                    ->join('residents', 'residents.street_id', '=', 'streets.id')
                    ->join('users', 'users.id', '=', 'residents.user_id')
                    ->where('streets.id', '=', $notification->street_id)
                    ->get();
                foreach ($users as $user)
                {
                    $details["name"] = $user->surname. " ".$user->othernames;
                    $details["email"] = $user->email;
                    $this->sendNotification($user, $message);
                }
                break;
            case "group":
                $users = NotificationGroup::query()
                    ->join('user_notificationgroup', 'notification_groups.id', '=', 'user_notificationgroup.group_id')
                    ->join('users', 'users.id', '=', 'user_notificationgroup.user_id')
                    ->where('notification_group.id', '=', $notification->group_id)
                    ->get();
                foreach ($users as $user)
                {
                    $this->sendNotification($user, $message);
                }
                break;
            case "all":
                $users= User::query();
                foreach ($users as $user)
                {
                    $this->sendNotification($user, $message);
                }
                break;
            default:
                //DO NOTHING
             break;
        }

    }

    function sendNotification($user, $details)
    {
        $user->notify(new adminSendsMessage());
    }
}
