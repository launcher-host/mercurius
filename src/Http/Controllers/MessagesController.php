<?php

namespace Launcher\Mercurius\Http\Controllers;

use Auth;
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
        $sender = Auth::user()->id;
        $receiver = $inp['recipient'];
        $message = $inp['message'];

        $result = $repo->send($sender, $receiver, $message);

        return response($result);
    }

    /**
     * Delete message for the current user.
     *
     * @param int               $message
     * @param MessageRepository $repo
     *
     * @return array
     */
    public function destroy($message, MessageRepository $repo)
    {
        $user = Auth::user();
        $msg = Message::findOrFail($message);

        return $repo->delete($msg, $user->id);
    }
}
