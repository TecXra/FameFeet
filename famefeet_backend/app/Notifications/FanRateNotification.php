<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class FanRateNotification extends Notification
{
    use Queueable;
    public $celeb;
    public $fan;
    public $rate_type;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fan, $celeb, $rate_type)
    {
        //
        $this->celeb = $celeb;
        $this->fan = $fan;
        $this->rate_type = $rate_type;
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
            ->content($this->fan->username.' sent you an ' . $this->rate_type . ' review. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->subject('You got a new ' . $this->rate_type . ' review')
                    ->line($this->fan->username.' sent you an ' . $this->rate_type . ' review.')
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
            'user_id' => $this->fan->id,
            'user_name' => $this->fan->username,
            'user_type' => $this->fan->user_type,
            'user_type_name' => $this->fan->user_type_name,
            'fan_or_celebrity_id' => $this->fan->id,
            // 'offer_id' =>$this->celebrityOfferData->id,
            // 'offer_title' => $this->celebrityOfferData->title,
            // 'offer_price' => $this->celebrityOfferData->coins,
            'message' => " sent you an " . $this->rate_type . " review"
        ];
    }
}
