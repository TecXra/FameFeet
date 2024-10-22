<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class CancelCustomeOfferNotification extends Notification
{
    use Queueable;
    public $offer;
    public $celebrityUser;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($offer,$celebrityUser)
    {
        //
        $this->offer = $offer;
        $this->celebrityUser = $celebrityUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return getUserNotificationChannelPreferences($this->celebrityUser);
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
                    ->subject('Custom Offer request rejected')
                    ->line($this->celebrityUser->username.' has rejected your custom offer request.')
                    ->line('Login now for further details!')
                    ->action('Notification Action', config('famefeet.client_base_url'))
                    ->line('Thank you for using FameFeet!');
    }

    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->celebrityUser->username.' has rejected your custom offer request. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
            //
            'user_id' => $this->celebrityUser->id,
            'user_name' => $this->celebrityUser->username,
            'user_type' => $this->celebrityUser->user_type,
            'user_type_name' => $this->celebrityUser->user_type_name,
            'fan_or_celebrity_id' => $this->offer->celebrity_id,
            'offer_id' =>$this->offer->id,
            'offer_title' => $this->offer->title,
            'offer_price' => $this->offer->coins,
            'message' => ' has rejected your custom offer request.',
        ];
    }
}
