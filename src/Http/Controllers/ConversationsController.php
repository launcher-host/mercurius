<?php

namespace Launcher\Mercurius\Http\Controllers;

use Illuminate\Http\Request;
use Launcher\Mercurius\Mercurius;
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
     * @param string                 $recipient
     * @param ConversationRepository $conversation
     * @param Request                $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show($recipient, Request $request, ConversationRepository $conversation)
    {
        $recipient = Mercurius::findUserOrFail($recipient);

        return response(
            $conversation->get($recipient, $request->offset, $request->pagesize)
        );
    }

    /**
     * Remove a conversation.
     *
     * @param string                 $recipient
     * @param ConversationRepository $conversation
     * @param Request                $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($recipient, Request $request, ConversationRepository $conversation)
    {
        $owner = $request->user()->id;
        $recipient = Mercurius::findUserOrFail($recipient);

        return response($conversation->delete($owner, $recipient));
    }
}
