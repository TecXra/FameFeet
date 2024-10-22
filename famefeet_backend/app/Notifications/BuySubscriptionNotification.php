<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class BuySubscriptionNotification extends Notification
{
    use Queueable;
    public $buySubscriptionUser;
    public $subscribe;
    public $subUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subscribe,$buySubscriptionUser,$subUser)
    {
        $this->subscribe = $subscribe;
        $this->buySubscriptionUser = $buySubscriptionUser;
        $this->subUser  = $subUser;
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
            ->content($this->buySubscriptionUser->username.' purchased your subscription. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->subject('You have a new subscriber')
                    ->line($this->buySubscriptionUser->username. ' purchased your subscription.')
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
            'user_id' => $this->buySubscriptionUser->id,
            'user_name' => $this->buySubscriptionUser->username,
            'user_type' => $this->buySubscriptionUser->user_type,
            'user_type_name' => $this->buySubscriptionUser->user_type_name,
            'fan_or_celebrity_id' => $this->subUser->id,
            'message' =>  "purchased your subscription.",
            // 'subscribe' => $this->subscribe,
        ];
    }
}
