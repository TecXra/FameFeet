<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CelebEnableSubcription implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $sender;
    public $receiver;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $sender,User $receiver)
    {
        //
        $this->sender = $sender;
        $this->receiver = $receiver;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('subscription-user.'.$this->receiver->id);
    }

    public function broadcastAs()
    {
        return 'CelebritySubscriptionUser';
    }

    public function broadcastWith()
    {
        return ["message" => $this->sender->username.' Disable your subscription.'];
    }
}
