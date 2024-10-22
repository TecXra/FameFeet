<?php

namespace App\Listeners;

use App\Events\AddTrackingNumberEvent;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\Order;
use App\Models\User;
use App\Notifications\TrackingNumberNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class AddTrackingNumberEventListener implements ShouldQueue
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
     * @param  \App\Events\AddTrackingNumberEvent  $event
     * @return void
     */
    public function handle(AddTrackingNumberEvent $event)
    {
        //
        // $order = Order::find($event->subOrder->order_id);
        $user = User::find($event->user->id);
        // if($user->user_type == config('famefeet.user_type.fan')){
            // $subUser = Fan::where('user_id',$user->id)->first();
        // }elseif($user->user_type == config('famefeet.user_type.celebrity')){
            // $subUser = Celebrity::where('user_id',$user->id)->first();
        // }else{
            $subUser = $user;
        // }

        Notification::send($event->notifyUser,new TrackingNumberNotification($event->subOrder,$event->user,$subUser));
    }
}
