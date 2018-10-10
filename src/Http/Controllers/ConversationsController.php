<?php

namespace Launcher\Mercurius\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Launcher\Mercurius\Repositories\ConversationRepository;

class ConversationsController extends Controller
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
     * Display a list of conversations for the home chat.
     *
     * @param ConversationRepository $conversation
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ConversationRepository $conversation)
    {
        $conversations = $conversation->all();

        return response($conversations);
    }

    /**
     * Display all users with active conversations with a given user id.
     *
     * @param ConversationRepository $conversation
     *
     * @return \Illuminate\Http\Response
     */
    public function recipients(ConversationRepository $conversation)
    {
        $recipients = $conversation->recipients();

        return response($recipients);
    }

    /**
     * Display a single conversation for a given user.
     *
     * @param Request                $request
     * @param int                    $receiver
     * @param ConversationRepository $conversation
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $receiver, ConversationRepository $conversation)
    {
        $inp = $request->only('offset', 'pagesize');

        $conversations = $conversation->get($receiver, $inp['offset'], $inp['pagesize']);

        return response($conversations);
    }

    /**
     * Remove a conversation.
     *
     * @param int                    $receiver
     * @param ConversationRepository $conversation
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($receiver, ConversationRepository $conversation)
    {
        $user = Auth::user();
        $res = $conversation->delete($user->id, $receiver);

        return response($res);
    }
}
