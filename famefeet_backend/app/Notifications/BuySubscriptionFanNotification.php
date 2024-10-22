<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class BuySubscriptionFanNotification extends Notification
{
    use Queueable;
    public $buySubscriptionUser;
    public $subscribe;
    public $subUser;
    public $celebSubscriptionUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subscribe,$buySubscriptionUser,$subUser,$celebSubscriptionUser)
    {
        $this->subscribe = $subscribe;
        $this->buySubscriptionUser = $buySubscriptionUser;
        $this->subUser  = $subUser;
        $this->celebSubscriptionUser = $celebSubscriptionUser;
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
            ->content($this->buySubscriptionUser->username.' Subscribed to you. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->line($this->celebSubscriptionUser->username. " Subscription Purchased!")
                    ->line('For further details, check your subscribed users!')
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
            'user_id' => $this->celebSubscriptionUser->id,
            'user_name' => $this->celebSubscriptionUser->username,
            'user_type' => $this->celebSubscriptionUser->user_type,
            'user_type_name' => $this->celebSubscriptionUser->user_type_name,
            'fan_or_celebrity_id' => $this->subUser->id,
            'message' => "'s Subscription Service Purchased!",
            // 'subscribe' => $this->subscribe,
        ];
    }
}
