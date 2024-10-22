<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddTrackingNumberEvent implements ShouldBroadcast
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
        //
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
        return new Channel('add-tracking-number.'.$this->notifyUser->id);
    }

    public function broadcastAs()
    {
        return 'AddTrackingNumber';
    }

    public function broadcastWith()
    {
        return ["message" => $this->user->username." Added tracking number to your order ".$this->subOrder->tracking_number];
    }
}
