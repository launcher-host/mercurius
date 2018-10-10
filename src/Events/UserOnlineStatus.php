<?php

namespace Launcher\Mercurius\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserOnlineStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The User id who has signed In/Out.
     *
     * @var int
     */
    public $user;

    /**
     * If the User went online/offline.
     *
     * @var bool
     */
    public $online;

    /**
     * Recipients receiving the event. Applying to recipients with
     * conversations with the User who fired the event.
     *
     * @var Collection
     */
    private $recipients;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $online)
    {
        $this->user = $user;
        $this->online = $online;

        // TODO
        // -----------------------------------
        // - Fetch Recipients
        //
        $this->recipients = collect([]);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'mercurius.user.status';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('mercurius.'.$this->user);

        // TODO
        // -----------------------------------
        // - Send event to each Recipient
        //
        // return $this->recipients->map(function ($recipient) {
        //     return new PrivateChannel('mercurius.user.status.'.$recipient->id);
        // });
    }
}
