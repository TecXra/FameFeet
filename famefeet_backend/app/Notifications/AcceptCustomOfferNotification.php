<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class AcceptCustomOfferNotification extends Notification
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
        return getUserNotificationChannelPreferences($this->offer);
    }

    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->celebrityUser->username.' Please check your content. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->line('Your requested content has been accepted. ')
                    ->line('Login now and check!')
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
            'user_id' => $this->celebrityUser->id,
            'user_name' => $this->celebrityUser->username,
            'user_type' => $this->celebrityUser->user_type,
            'user_type_name' => $this->celebrityUser->user_type_name,
            'fan_or_celebrity_id' => $this->offer->celebrity_id,
            'offer_id' =>$this->offer->id,
            'offer_title' => $this->offer->title,
            'offer_price' => $this->offer->coins,
            'message' =>"Accept the Offer!",
        ];
    }
}
