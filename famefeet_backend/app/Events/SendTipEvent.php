<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendTipEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $tip;
    public $sender;
    public $receiver;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($tip,$sender,$receiver)
    {
        $this->tip = $tip;
        $this->sender  = $sender;
        $this->receiver = $receiver;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('send-tip.'.$this->tip->receiver_id);
    }

    public function broadcastAs()
    {
        return 'SendTip';
    }

    public function broadcastWith()
    {
        return ["message" => $this->sender->username.'  Send a tip.'];
    }
}
