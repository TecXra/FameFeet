<?php

namespace App\Notifications;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class WithdrawalNotification extends Notification
{
    use Queueable;
    public $admin;
    public $celeb;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($celeb,$admin)
    {
        //
        $this->admin = $admin;
        $this->celeb = $celeb;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return getUserNotificationChannelPreferences($this->celeb);
        return ['database', 'mail'];
    }

    // public function toVonage($notifiable){
    //     return (new VonageMessage())
    //         ->content($this->user->username.' Withdrawal a request. Go to '.url('/').'now to check! Thank you for using FameFeet')
    //         ->from('Famefeet');
    // }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $celeb = User::where('id', $this->celeb)->pluck('username');
        return (new MailMessage)
                    ->line($celeb[0].' Has sent a withdraw request.')
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
            'user_id' => $this->admin->id,
            'user_name' => $this->admin->username,
            'user_type' => $this->admin->user_type,
            'user_type_name' => $this->admin->user_type_name,
            'fan_or_celebrity_id' => $this->celeb,
            'message' => " Withdrawal request",

        ];
    }
}
