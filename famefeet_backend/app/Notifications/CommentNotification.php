<?php

namespace App\Notifications;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;
    public $user;
    public $subUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$subUser)
    {
        //
        $this->user = $user;
        $this->subUser = $subUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function via($notifiable)
    // {
    //     return getcheckCelebrityNotificationType($this->user);
    // }
    public function via($notifiable)
    {
        // return ['database', 'mail'];
        return getUserNotificationChannelPreferences($this->subUser);
    }


    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->subUser->username.' has sent you a comment. Go to '.url('/').'now to check! Thank you for using FameFeet')
            ->from('Famefeet');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
                    ->subject('You have a new comment')
                    ->line($this->subUser->username.' has sent you a comment.')
                    ->action('Notification Action', config('famefeet.client_base_url'))
                    ->line('Thank you for using FameFeet!');
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
            'user_id' => $this->subUser->id,
            'user_name' => $this->subUser->username,
            'user_type' => $this->subUser->user_type,
            'user_type_name' => $this->subUser->user_type_name,
            'fan_or_celebrity_id' => $this->subUser->id,
            'message' => " has sent you a comment",

        ];
    }
}
