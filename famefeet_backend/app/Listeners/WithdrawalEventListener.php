<?php

namespace App\Listeners;

use App\Events\WithdrawalEvent;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\User;
use App\Notifications\WithdrawalNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class WithdrawalEventListener implements ShouldQueue
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
     * @param  \App\Events\WithdrawalEvent  $event
     * @return void
     */
    public function handle(WithdrawalEvent $event)
    {
        $senderUser = Auth::id();

        $receiverUser = User::find($event->admin);

        Notification::send($receiverUser,new WithdrawalNotification($senderUser,$receiverUser));
    }
}
