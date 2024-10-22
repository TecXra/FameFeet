<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CancelCustomeOfferEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $offer;
    public $celebrity;
    public $notifyUser;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($offer,$celebrity,$notifyUser)
    {
        //
        $this->offer = $offer;
        $this->celebrity = $celebrity;
        $this->notifyUser = $notifyUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('cancel-offer.'.$this->notifyUser->id);
    }

    public function broadcastAs()
    {
        return 'CancelOffer';
    }

    public function broadcastWith()
    {
        return ["message" => $this->celebrity->username.' Your Offer has been Rejected '.$this->offer->price];
    }
}
