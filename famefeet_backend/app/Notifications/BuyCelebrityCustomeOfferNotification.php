<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class BuyCelebrityCustomeOfferNotification extends Notification
{
    use Queueable;
    public $celebritySendOffer;
    public $buyOfferUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($celebritySendOffer,$buyOfferUser)
    {
        //
        $this->celebritySendOffer = $celebritySendOffer;
        $this->buyOfferUser = $buyOfferUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return getUserNotificationChannelPreferences($this->celebritySendOffer);

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
                    ->subject('Custom offer sold')
                    ->line($this->buyOfferUser->username. ' has bought your custom offer.')
                    ->action('Notification Action', config('famefeet.client_base_url'))
                    ->line('Thank you for using FameFeet!');
    }

    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->buyOfferUser->username.' has bought your custom offer. Go to .'.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
            'user_id' => $this->buyOfferUser->id,
            'user_name' => $this->buyOfferUser->username,
            'user_type' => $this->buyOfferUser->user_type,
            'user_type_name' => $this->buyOfferUser->user_type_name,
            'fan_or_celebrity_id' => $this->celebritySendOffer->fan_id,
            'offer_id' =>$this->celebritySendOffer->id,
            'offer_title' => $this->celebritySendOffer->title,
            'offer_price' => $this->celebritySendOffer->coins,
            'message' =>"  has bought your custom offer.",
        ];
    }
}
