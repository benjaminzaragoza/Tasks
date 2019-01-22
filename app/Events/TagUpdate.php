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

class TagUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tag, $old_tag, $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($old_tag, Tag $tag, User $user)
    {
        $this->tag = $tag;
        $this->old_task = $old_tag;
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
