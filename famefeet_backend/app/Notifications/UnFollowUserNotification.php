<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class UnFollowUserNotification extends Notification
{
    use Queueable;
    public $unfollower;
    public $subUser;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($unfollower,$subUser)
    {
        //
        $this->unfollower = $unfollower;
        $this->subUser = $subUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return getUserNotificationChannelPreferences($this->subUser);
    }


    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->unfollower->username.' has unfollowed you. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->subject('Someone unfollowed you')
                    ->line($this->unfollower->username.' has unfollowed you.')
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
            'user_id' => $this->unfollower->id,
            'user_name' => $this->unfollower->username,
            'user_type' => $this->unfollower->user_type,
            'user_type_name' => $this->unfollower->user_type_name,
            'message' => ' has unfollowed you',
        ];
    }
}
