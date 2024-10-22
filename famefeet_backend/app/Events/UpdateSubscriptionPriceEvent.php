<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateSubscriptionPriceEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $subscription;
    public $notifyUser;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subscription,$notifyUser,$user)
    {
        //
        $this->subscription = $subscription;
        $this->notifyUser = $notifyUser;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('edit-subscription.'.$this->notifyUser->id);
    }

    public function broadcastAs()
    {
        return 'EditSubscription';
    }

    public function broadcastWith()
    {
        return ["message" => $this->user->username. ' Update subscription price.'];
    }
}
