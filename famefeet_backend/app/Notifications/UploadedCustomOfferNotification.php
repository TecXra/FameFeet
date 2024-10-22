<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class UploadedCustomOfferNotification extends Notification
{
    use Queueable;
    public $offer;
    public $uplodOfferUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($offer,$uplodOfferUser)
    {
        //
        $this->offer = $offer;
        $this->uplodOfferUser = $uplodOfferUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return getUserNotificationChannelPreferences($this->uplodOfferUser);
    }

    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->uplodOfferUser->username.' uploadeded the content for your Custom Offer request.  Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->subject('You got content for your Custom Offer request')
                    ->line($this->uplodOfferUser->username.' uploadeded the content for your Custom Offer request.')
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
            'user_id' => $this->uplodOfferUser->id,
            'user_name' => $this->uplodOfferUser->username,
            'user_type' => $this->uplodOfferUser->user_type,
            'user_type_name' => $this->uplodOfferUser->user_type_name,
            'fan_or_celebrity_id' => $this->offer->celebrity_id,
            'offer_id' =>$this->offer->id,
            'offer_title' => $this->offer->title,
            'offer_price' => $this->offer->coins,
            'message' => " uploadeded the content for your Custom Offer request.",
        ];
    }
}
