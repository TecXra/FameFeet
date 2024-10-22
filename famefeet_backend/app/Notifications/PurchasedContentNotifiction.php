<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class PurchasedContentNotifiction extends Notification
{
    use Queueable;
    public $post;
    public $user;
    public $subUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post,$user,$subUser)
    {
        //
        $this->post = $post;
        $this->user = $user;
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
            ->content($this->user->username.' Purchased your content. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->line($this->user->username. ' Bought Content')
                    ->line('Further Details Check Purchase Content Section!')
                    ->action('Notification Action', config('famefeet.client_base_url'))
                    ->line('Thank you for using our application!');
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
            'user_id' => $this->user->id,
            'user_name' => $this->user->username,
            'user_type' => $this->user->user_type,
            'user_type_name' => $this->user->user_type_name,
            'fan_or_celebrity_id' => $this->subUser->id,
            'message' => " Bought Content",
            'post' => $this->post,
        ];
    }
}
