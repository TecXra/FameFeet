<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateMessagePriceEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $messagePrice;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($msgPrice,$user)
    {
        //
        $this->messagePrice = $msgPrice;
        $this->user = $user;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
       public function broadcastOn()
    {
        return new Channel('update-message-price');
    }

    public function broadcastAs()
    {
        return 'UpdateMessagePrice';
    }

    public function broadcastWith()
    {
        return ["data" => ['userId'=>$this->user->id,'messagePrice'=>$this->messagePrice]];
    }
}
