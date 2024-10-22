<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SharePostEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $post;
    public $notifyUser;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($post,$notifyUser,$user)
    {
        //
        $this->post = $post;
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
        return new Channel('share-post.'.$this->notifyUser->id);
    }

    public function broadcastAs()
    {
        return 'SharePost';
    }

    public function broadcastWith()
    {
        return ["message" => $this->user->username. ' Sent You an Offer!'];
    }
}
