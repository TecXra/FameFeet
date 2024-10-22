<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WithdrawalEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $redeem;
    public $celebrity;
    public $admin;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($redeem,$celebrity,$admin)
    {
        $this->redeem = $redeem;
        $this->celebrity  = $celebrity;
        $this->admin = $admin;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('withdrawal.'.$this->admin);
    }

    public function broadcastAs()
    {
        return 'Withdrawal';
    }

    public function broadcastWith()
    {
        return ["message" => $this->celebrity->username.'  Withdrawal a request.'];
    }
}
