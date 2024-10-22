<?php

namespace App\Listeners;

use App\Events\OrderCancelAdminEvent;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\User;
use App\Notifications\OrderCancelAdminNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class OrderCancelAdminEventListener implements ShouldQueue
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
     * @param  \App\Events\OrderCancelAdminEvent  $event
     * @return void
     */
    public function handle(OrderCancelAdminEvent $event)
    {
        $senderUser = $event->celebrity;

        $receiverUser = User::find($event->admin);

        Notification::send($receiverUser,new OrderCancelAdminNotification($senderUser,$receiverUser));
    }
}
