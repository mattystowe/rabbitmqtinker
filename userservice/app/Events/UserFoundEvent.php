<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;

class UserFoundEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $correlation_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $correlation_id)
    {
        $this->user = $user;
        $this->correlation_id = $correlation_id;
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
