<?php

namespace Launcher\Mercurius\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Launcher\Mercurius\Repositories\ConversationRepository;

class UserStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The User slug who's status changed.
     *
     * @var string
     */
    public $user;

    /**
     * If the User goes active/idle/inactive.
     *
     * @var string
     */
    public $status;

    /**
     * Users holding conversations with the current User.
     *
     * @var array
     */
    private $recipients;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $status)
    {
        $this->user = $user;
        $this->status = $status;

        $this->recipients = (new ConversationRepository())->recipients();
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'mercurius.user.status.changed';
    }

    /**
     * Determine if this event should be broadcast.
     *
     * @return bool
     */
    public function broadcastWhen()
    {
        return count($this->recipients) > 0;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        foreach ($this->recipients as $recipient) {
            $channels[] = new PrivateChannel('mercurius.'.$recipient);
        }

        return $channels;
    }
}
