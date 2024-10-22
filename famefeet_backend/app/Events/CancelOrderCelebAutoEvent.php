<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CancelOrderCelebAutoEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $subOrder;
    public $user;
    public $notifyUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subOrder,$user,$notifyUser)
    {
        $this->subOrder = $subOrder;
        $this->user = $user;
        $this->notifyUser = $notifyUser;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('cancel-order-celeb-auto.'.$this->notifyUser->id);
    }

    public function broadcastAs()
    {
        return 'CancelOrderCelebAuto';
    }

    public function broadcastWith()
    {
        return ["message" => $this->user->username." ".$this->subOrder->status."ed your Order"];
    }

}
