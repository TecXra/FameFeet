<?php

namespace App\Listeners;

use App\Events\UnFollowUser;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Notifications\UnFollowUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class UnFollowUserEventListener implements ShouldQueue
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
     * @param  \App\Events\UnFollowUser  $event
     * @return void
     */
    public function handle(UnFollowUser $event)
    {
        //
        // if($event->unfollowerUser->user_type == config('famefeet.user_type.fan')){
        //     $subUser = Fan::where('user_id',$event->unfollowerUser->id)->first();
        // }elseif($event->unfollowerUser->user_type == config('famefeet.user_type.celebrity')){
        //     $subUser = Celebrity::where('user_id',$event->unfollowerUser->id)->first();
        // }else{
            $subUser = $event->unfollowerUser;
        // }
        Notification::send($event->unfollowingUser,new UnFollowUserNotification($event->unfollowerUser,$event->unfollowingUser));
    }
}
