<?php

namespace App\Listeners;

use App\Events\SendCustomOffer;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\User;
use App\Notifications\CustomOfferNotification;
use App\Notifications\SendOfferNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendCustomOfferEventListener implements ShouldQueue
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
     * @param  \App\Events\SendCustomOffer  $event
     * @return
     */
    public function handle(SendCustomOffer $event)
     {
        $fan_id = $event->offer->fan_id;
        $celebrity_id = $event->offer->celebrity_id;
        $fan = Fan::find($fan_id);
        $fanUser = User::where('id',$fan->user_id)->first();
        $celebrity = Celebrity::find($celebrity_id);
        $celebrityUser = User::where('id',$celebrity->user_id)->first();
        
        // \Log::info("offer");
        // \Log::info($event->offer);
        // \Log::info("fanuser");
        // \Log::info($fanUser);
        // \Log::info("celeb");
        // \Log::info($celebrityUser);
        // getUserNotificationChannelPreferences($celebrityUser->id);
        // \Log::info();
        

        Notification::send($celebrityUser,new CustomOfferNotification($event->offer,$fanUser, $celebrityUser));
    }
}
