<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class CelebrityRateNotification extends Notification
{
    use Queueable;
    public $celeb;
    public $fan;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($celeb,$fan)
    {
        //
        $this->celeb = $celeb;
        $this->fan = $fan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return getUserNotificationChannelPreferences($this->celeb);
        // return ['database', 'mail'];
    }


    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->fan->username.' sent you a review. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->line($this->celeb->username.' Sent you a review! ')
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
            'user_id' => $this->celeb->id,
            'user_name' => $this->celeb->username,
            'user_type' => $this->celeb->user_type,
            'user_type_name' => $this->celeb->user_type_name,
            'fan_or_celebrity_id' => $this->fan->id,
            // 'offer_id' =>$this->celebrityOfferData->id,
            // 'offer_title' => $this->celebrityOfferData->title,
            // 'offer_price' => $this->celebrityOfferData->coins,
            'message' => " Sent you a review! ",
        ];
    }
}
