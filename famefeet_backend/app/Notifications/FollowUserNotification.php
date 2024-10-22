<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class FollowUserNotification extends Notification
{
    use Queueable;
    public $follower;
    public $subUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($follower,$subUser)
    {
        //
        $this->follower = $follower;
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
            ->content($this->follower->username.' followed you. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->subject('You have a new follower')
                    ->line($this->follower->username.' followed you.')
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
            'user_id' => $this->follower->id,
            'user_name' => $this->follower->username,
            'user_type' => $this->follower->user_type,
            'user_type_name' => $this->follower->user_type_name,
            'fan_or_celebrity_id' => $this->subUser->id,
            'message' => ' followed you.',
        ];
    }
}
