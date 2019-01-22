<?php

namespace App\Events;

use App\Tag;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TagDelete
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task, $user;

    /**
     * Create a new event instance.
     *
     * @param Tag $task
     * @param User $user
     */
    public function __construct(Tag $tag, User $user)
    {
        $this->tag = $tag;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
