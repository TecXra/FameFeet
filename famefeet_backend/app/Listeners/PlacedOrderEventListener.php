<?php

namespace App\Listeners;

use App\Events\PlacedOrderEvent;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use App\Notifications\SocksOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class PlacedOrderEventListener implements ShouldQueue
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
     * @param  \App\Events\PlacedOrderEvent  $event
     * @return void
     */
    public function handle(PlacedOrderEvent $event)
    {
        //
        $order = Order::find($event->subOrderObj->order_id);
        $user = User::find($order->user_id);
        // if($user->user_type == config('famefeet.user_type.fan')){
        //     $subUser = Fan::where('user_id',$user->id)->first();
        // }elseif($user->user_type == config('famefeet.user_type.celebrity')){
        //     $subUser = Celebrity::where('user_id',$user->id)->first();
        // }else{
            $subUser = $user;
        // }

        $celebrity = Celebrity::find($event->subOrderObj->celebrity_id);

        $notifyUser = User::find($celebrity->user_id);

        Notification::send($notifyUser,new SocksOrderNotification($order,$user,$notifyUser));
    }
}
