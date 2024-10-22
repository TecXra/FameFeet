<?php

namespace App\Listeners;

use App\Events\UploadCustomOffer;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\User;
use App\Notifications\UploadedCustomOfferNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class UploadCustomOfferEventListener implements ShouldQueue
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
     * @param  \App\Events\UploadCustomOffer  $event
     * @return void
     */
    public function handle(UploadCustomOffer $event)
    {
        //
        $fan_id = $event->offer->fan_id;
        $celebrity_id = $event->offer->celebrity_id;
        $fan = Fan::find($fan_id);
        $fanUser = User::where('id',$fan->user_id)->first();
        $celebrity = Celebrity::find($celebrity_id);
        $celebrityUser = User::where('id',$celebrity->user_id)->first();
        Notification::send($fanUser,new UploadedCustomOfferNotification($event->offer,$celebrityUser));
    }
}
