<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuyCelebrityCustomeOffer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $celebritySendOffer;
    public $user;
    public $notifyUser;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($celebritySendOffer,$user,$notifyUser)
    {
        $this->celebritySendOffer = $celebritySendOffer;
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
        return new Channel('buy-custom-offer.'.$this->notifyUser->id);
    }

    public function broadcastAs()
    {
        return 'BuyCustomOffer';
    }

    public function broadcastWith()
    {
        return ["message" => $this->user->username.' Bought a custom offer! '.$this->celebritySendOffer->price];
    }
}
