<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class CelebrityCustomOfferNotification extends Notification
{
    use Queueable;
    public $celebrityOfferData;
    public $userSendOffer;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($celebrityOfferData,$userSendOffer)
    {
        //
        $this->celebrityOfferData = $celebrityOfferData;
        $this->userSendOffer = $userSendOffer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return getUserNotificationChannelPreferences($this->userSendOffer);
    }

    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->userSendOffer->username.' sent you a custom offer request for $'.$this->celebrityOfferData->price.'. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->subject('You have a new Custom Offer request')
                    ->line($this->userSendOffer->username.' sent you a custom offer request for $'.$this->celebrityOfferData->price)
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
            //
            'user_id' => $this->userSendOffer->id,
            'user_name' => $this->userSendOffer->username,
            'user_type' => $this->userSendOffer->user_type,
            'user_type_name' => $this->userSendOffer->user_type_name,
            'fan_or_celebrity_id' => $this->celebrityOfferData->celebrity_id,
            'offer_id' =>$this->celebrityOfferData->id,
            'offer_title' => $this->celebrityOfferData->title,
            'offer_price' => $this->celebrityOfferData->coins,
            'message' => " Sent you a custom offer! ",
        ];
    }
}
