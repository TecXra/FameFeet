<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendWarningMailToAutoSubcribeNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $user;
    public $subscription;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$subscription)
    {
        //
        $this->user = $user;
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->line('Please disable your subscription for '.$this->user->username)
                    ->line(' otherwise, it will be renewed automatically and you will be charged:' .$this->subscription->coins)
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
        ];
    }
}
