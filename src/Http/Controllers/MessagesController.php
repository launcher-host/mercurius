<?php

namespace Launcher\Mercurius\Http\Controllers;

use Illuminate\Http\Request;
use Launcher\Mercurius\Mercurius;
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
        $request->validate([
            'recipient' => 'required|string',
            'message'   => 'required|string',
        ]);

        $from = $request->user()->id;
        $receiver = Mercurius::findUserOrFail($request->recipient);
        $message = $request->message;

        return response($repo->send($from, $receiver, $message));
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
