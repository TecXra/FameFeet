<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ForgotPasswordNotification extends Notification
{
    use Queueable;
    public $user;
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$token)
    {
        //
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return getUserNotificationChannelPreferences($this->user);
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
                    ->subject('FameFeet password reset')
                    ->line('You have requested a verification code to reset your password. Please use this code for verification.')
                    ->line(new HtmlString("<br /><p style='text-align: center;'><strong style='background-color: #cccccc; padding: 15px 25px; border-radius: 10px;'>{$this->token}</strong></p><br />"))
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
