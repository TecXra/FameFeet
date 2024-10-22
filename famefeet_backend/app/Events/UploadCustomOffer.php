<?php

namespace App\Events;

use App\Models\Offer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UploadCustomOffer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $offer;
    public $user;
    public $notifyUser;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($offer,$user,$notifyUser)
    {
        $this->offer = $offer;
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
        return new Channel('upload-offer.'.$this->notifyUser->id);
    }

    public function broadcastAs()
    {
        return 'UploadOffer';
    }

    public function broadcastWith()
    {
        return ["message" => $this->user->username.' Uploaded the Offer Content! '.$this->offer->price];
    }
}
