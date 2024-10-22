<?php

namespace App\Events;

use App\Models\OrderDetail;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlacedOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $subOrderObj;
    public $notifyUser;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subOrderObj,$notifyUser,$user)
    {
        //
        $this->subOrderObj = $subOrderObj;
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
        return new Channel('place-order.'.$this->notifyUser->id);
    }

    public function broadcastAs()
    {
        return 'PlaceOrder';
    }

    public function broadcastWith()
    {
        return ["message" => $this->user->username.' Bought your store item.'];
    }
}
