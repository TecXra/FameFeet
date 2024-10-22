<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CustomOfferNotification extends Notification
{
    use Queueable;
    public $offerData;
    public $userSendOffer;
    public $celebrityUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($offerData,$userSendOffer, $celebrityUser)
    {
        $this->offerData = $offerData;
        $this->userSendOffer = $userSendOffer;
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

    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->userSendOffer->username.' has sent you a custom request. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->line($this->userSendOffer->username.' Sent You a Custom Offer Request.')
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
        // Log::channel('custom')->info(json_encode($this->userSendOffer));
        // Log::channel('send-offer')->info(json_encode($this->offerData));
        return [
            'user_id' => $this->userSendOffer->id,
            'user_name' => $this->userSendOffer->username,
            'user_type' => $this->userSendOffer->user_type,
            'user_type_name' => $this->userSendOffer->user_type_name,
            'fan_or_celebrity_id' => $this->offerData->fan_id,
            'offer_id' =>$this->offerData->id,
            'offer_title' => $this->offerData->title,
            'offer_price' => $this->offerData->coins,
            'message' => " Sent You a Custom Offer! ",
        ];
    }
}
