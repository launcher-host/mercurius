<?php

namespace Launcher\Mercurius\Http\Controllers;

use Illuminate\Http\Request;
use Launcher\Mercurius\Models\Message;
use Launcher\Mercurius\Repositories\MessageRepository;

class MessagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Send a message from the current user.
     *
     * @param MessageRepository $repo
     * @param Request           $request
     *
     * @return array
     */
    public function send(MessageRepository $repo, Request $request)
    {
        $inp = $request->only('recipient', 'message');
        $receiver = $inp['recipient'];
        $message = $inp['message'];

        $result = $repo->send($request->user()->id, $receiver, $message);

        return response($result);
    }

    /**
     * Delete message for the current user.
     *
     * @param int               $message
     * @param MessageRepository $repo
     * @param Request           $request
     *
     * @return array
     */
    public function destroy($message, MessageRepository $repo, Request $request)
    {
        $msg = Message::findOrFail($message);

        return $repo->delete($msg, $request->user()->id);
    }
}
