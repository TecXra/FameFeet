<?php

namespace App\Listeners;

use App\Events\BuyCelebrityCustomeOffer;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\User;
use App\Notifications\BuyCelebrityCustomeOfferNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class BuyCelebrityCustomeOfferEventListener implements ShouldQueue
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
     * @param  \App\Events\BuyCelebrityCustomeOffer  $event
     * @return void
     */
    public function handle(BuyCelebrityCustomeOffer $event)
    {
        //
        $fan_id = $event->celebritySendOffer->fan_id;
        $celebrity_id = $event->celebritySendOffer->celebrity_id;
        $fan = Fan::where('id',$fan_id)->first();
        $fanUser = User::where('id',$fan->user_id)->first();
        $celebrity = Celebrity::find($celebrity_id);
        $celebrityUser = User::where('id',$celebrity->user_id)->first();
        Notification::send($celebrityUser,new BuyCelebrityCustomeOfferNotification($event->celebritySendOffer,$fanUser));
    }
}
