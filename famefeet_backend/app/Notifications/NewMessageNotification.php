<?php

namespace App\Notifications;

use App\Models\Message;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;
    public $message;
    public $sender;
    public $subUser;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message,$sender,$subUser)
    {
        //
        $this->message = $message;
        $this->sender = $sender;
        $this->subUser = $subUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return getUserNotificationChannelPreferences($this->subUser);
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
                    ->line($this->sender->username.' has sent you a message. ')
                    ->line(' Login now to respond! ')
                    ->action('Notification Action', config('famefeet.client_base_url'))
                    ->line('Thank you for using FameFeet!');
    }
    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->sender->username.' has sent you a message on FameFeet. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
            'user_id' => $this->sender->id,
            'user_name' => $this->sender->username,
            'user_type' => $this->sender->user_type,
            'user_type' => $this->sender->user_type_name,
            'fan_or_celebrity_id' => $this->subUser->id,
            // 'offer' =>$this->message,
            'message' =>" you have a message from the ",
        ];
    }
}
