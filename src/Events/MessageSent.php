<?php

namespace Launcher\Mercurius\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Launcher\Mercurius\Models\Message;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User receiving the event.
     *
     * @var App\User
     */
    public $receiver;

    /**
     * User sender.
     *
     * @var App\User
     */
    public $sender;

    /**
     * Message.
     *
     * @var Launcher\Mercurius\Models\Message
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($receiver, $sender, Message $message)
    {
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->message = $message;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'mercurius.message.sent';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('mercurius.'.$this->receiver->id);
    }
}
