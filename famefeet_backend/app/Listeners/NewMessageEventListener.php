<?php

namespace App\Listeners;

use App\Events\NewMessage;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NewMessageEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewMessage  $event
     * @return void
     */
    public function handle(NewMessage $event)
    {
        //
        $receiver = User::find($event->message->receiver_id);
        $sender = User::find($event->message->sender_id);
        // if($sender->user_type == config('famefeet.user_type.fan')){
        //     $subUser = Fan::where('user_id',$sender->id)->first();
        // }elseif($sender->user_type == config('famefeet.user_type.celebrity')){
        //     $subUser = Celebrity::where('user_id',$sender->id)->first();
        // }else{
            $subUser = $sender;
        // }
        Notification::send($receiver,new NewMessageNotification($event->message,$sender,$subUser));
    }
}
