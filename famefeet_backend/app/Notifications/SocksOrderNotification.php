<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class SocksOrderNotification extends Notification
{
    use Queueable;
    public $order;
    // public $shop;
    public $user;
    public $subUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order,$user,$subUser)
    {
        //
        $this->order = $order;
        // $this->shop = $shop;
        $this->user = $user;
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

    public function toVonage($notifiable){
        return (new VonageMessage())
            ->content($this->user->username.' has placed an order. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
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
                    ->subject('You got a new order')
                    ->line($this->user->username.' has placed an order.')
                    ->line(' For more details, go to My Orders now!')
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
            'message' => " has placed an order.",
            'user_id' => $this->user->id,
            'user_name' => $this->user->username,
            'user_type' => $this->user->user_type,
            'user_type_name' => $this->user->user_type_name,
            'fan_or_celebrity_id' => $this->subUser->id,
            // 'shop_id' => $this->shop->id,
            // 'shop_title' => $this->shop->title,
        ];
    }
}
