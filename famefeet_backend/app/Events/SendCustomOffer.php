<?php

namespace App\Events;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendCustomOffer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $offer;
    public $user;
    public $notifyUser;
    // public $offerSender;
    // public $offerReceiver;
    // User $offerSender,User $offerReceiver
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($offer,$user,$notifyUser)
    {
        //
        $this->offer = $offer;
        $this->user = $user;
        $this->notifyUser = $notifyUser;
        // $this->offerSender = $offerSender;
        // $this->offerReceiver = $offerReceiver;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('send-offer.'.$this->notifyUser->id);
    }

    public function broadcastAs()
    {
        return 'SendOffer';
    }

    public function broadcastWith()
    {
        return ["message" => $this->user->username.' Sent You a Custom Request! '.$this->offer->price];
    }
}
