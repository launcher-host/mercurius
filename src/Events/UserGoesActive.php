<?php

namespace Launcher\Mercurius\Events;

use Illuminate\Queue\SerializesModels;

class UserGoesActive
{
    use SerializesModels;

    /**
     * The User going active.
     *
     * @var int
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
