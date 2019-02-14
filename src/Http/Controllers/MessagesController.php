<?php

namespace Launcher\Mercurius\Http\Controllers;

use Illuminate\Http\Request;
use Launcher\Mercurius\Facades\Mercurius;
use Launcher\Mercurius\Repositories\MessageRepository;
use Launcher\Mercurius\Repositories\UserRepository;

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
     * Index all messages
     *
     * @return mixed
     */
    public function index()
    {
        return View('mercurius::mercurius');
    }

    /**
     * Send a message from the current user.
     *
     * @param MessageRepository $repo
     * @param Request           $request
     *
     * @return array
     */
    public function send(Request $request, MessageRepository $msg, UserRepository $user)
    {
        $request->validate([
            'recipient' => 'required|string',
            'message'   => 'required|string',
        ]);
        $from = $request->user();
        $receiver = $user->find($request->recipient);
        $message = $request->message;

        return response($msg->send($from, $receiver, $message));
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
    public function destroy($message, MessageRepository $repo, Request $request, UserRepository $user)
    {
        $msg = Mercurius::model('message')->findOrFail($message);

        return $repo->delete($msg, $request->user()->id);
    }
}
