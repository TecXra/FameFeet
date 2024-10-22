<?php

namespace App\Listeners;

use App\Events\SharePostEvent;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\Post;
use App\Notifications\SharePostNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SharePostEventListener implements ShouldQueue
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
     * @param  \App\Events\SharePostEvent  $event
     * @return void
     */
    public function handle(SharePostEvent $event)
    {

        // Log::channel('custom')->info(json_encode());
        // $post = Post::find($event->post->post_id);
        // if($event->user->user_type == config('famefeet.user_type.fan')){
        //     $subUser = Fan::where('user_id',$event->user->id)->first();
        // }elseif($event->user->user_type == config('famefeet.user_type.celebrity')){
        //     $subUser = Celebrity::where('user_id',$event->user->id)->first();
        // }else{
            $subUser = $event->user;
        // }

        Notification::send($event->notifyUser,new SharePostNotification($event->post,$event->user,$subUser));

    }
}
