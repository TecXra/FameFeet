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

class UnFollowUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $unfollowerUser;
    public $unfollowingUser;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $unfollowerUser,User $unfollowingUser)
    {
        //
        $this->unfollowerUser = $unfollowerUser;
        $this->unfollowingUser = $unfollowingUser;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('unfollow-user.'.$this->unfollowingUser->id);
    }

    public function broadcastAs()
    {
        return 'UnFollowUser';
    }

    public function broadcastWith()
    {
        return ["message" => $this->unfollowerUser->username.' Unfollowed you.'];
    }
}
