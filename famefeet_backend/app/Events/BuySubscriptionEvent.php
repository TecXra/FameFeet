<?php

namespace App\Events;

use App\Models\SubscribeUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuySubscriptionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $subscribeUser;
    public $notifyUser;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subscribeUser,$notifyUser,$user)
    {
        //
        $this->subscribeUser = $subscribeUser;
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
        return new Channel('buy-subscription.'.$this->notifyUser->id);
    }

    public function broadcastAs()
    {
        return 'BuySubscription';
    }

    public function broadcastWith()
    {
        return ["message" => $this->user->username. ' Bought your subscription.'];
    }
}
