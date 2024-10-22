<?php

namespace App\Listeners;

use App\Events\SendTipEvent;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\User;
use App\Notifications\SentTipNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendTipEventListener implements ShouldQueue
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
     * @param  \App\Events\SendTipEvent  $event
     * @return void
     */
    public function handle(SendTipEvent $event)
    {
        $senderUser = User::find($event->tip->sender_id);
        // if($senderUser->user_type == config('famefeet.user_type.fan')){
        //     $subUser = Fan::where('user_id',$senderUser->id)->first();
        // }elseif($senderUser->user_type == config('famefeet.user_type.celebrity')){
        //     $subUser = Celebrity::where('user_id',$senderUser->id)->first();
        // }else{
        //     $subUser = $senderUser;
        // }

        $receiverUser = User::find($event->tip->receiver_id);

        Notification::send($receiverUser,new SentTipNotification($senderUser,$receiverUser));
    }
}
