<?php

namespace App\Listeners;

use App\Events\UpdateSubscriptionPriceEvent;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Notifications\UpdateSubscriptionPriceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class UpdateSubscriptionPriceEventListener implements ShouldQueue
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
     * @param  \App\Events\UpdateSubscriptionPriceEvent  $event
     * @return void
     */
    public function handle(UpdateSubscriptionPriceEvent $event)
    {

        // if($event->user->user_type == config('famefeet.user_type.fan')){
        //     $subUser = Fan::where('user_id',$event->user->id)->first();
        // }elseif($event->user->user_type == config('famefeet.user_type.celebrity')){
        //     $subUser = Celebrity::where('user_id',$event->user->id)->first();
        // }else{
            $subUser = $event->user;
        // }

        Notification::send($event->notifyUser,new UpdateSubscriptionPriceNotification($event->subscription,$event->user,$subUser));
    }
}
