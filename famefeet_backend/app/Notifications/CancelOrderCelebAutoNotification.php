<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancelOrderCelebAutoNotification extends Notification
{
    use Queueable;
    public $subOrder;
    public $user;
    public $subUser;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subOrder,$user,$subUser)
    {
        $this->subOrder = $subOrder;
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
        //  return ['mail', 'database'];
       return getUserNotificationChannelPreferences($this->subUser);
    }
    // public function toVonage($notifiable){
    //     return (new VonageMessage())
    //         ->content($this->user->username.' The introduction to the notification. Go to '.url('/').'now to check! Thank you for using FameFeet')->from('Famefeet');
    // }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Due to policy, the celebrity failed to either accept the order or upload the tracking number within 48 hours. Your money has been added back to your wallet.')
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', config('famefeet.client_base_url'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if($this->subOrder->status == 'pending'){
            $status =  $this->subOrder->status.'ed';
      }else{
          $status = $this->subOrder->status;
      }
        return [
            'message' =>"Your socks order has been " .$status."led please see email notification",
            // 'shop_id' => $this->shop->id,
            // 'shop_item_title' => $this->shop->title,
            'user_id' => $this->user->id,
            'user_name' => $this->user->username,
            'user_type' => $this->user->user_type,
            'user_type_name' => $this->user->user_type_name,
            'fan_or_celebrity_id' => $this->subUser->id,
        ];
    }
}
