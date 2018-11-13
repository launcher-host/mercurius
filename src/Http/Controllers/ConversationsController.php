<?php

namespace Launcher\Mercurius\Http\Controllers;

use Illuminate\Http\Request;
use Launcher\Mercurius\Repositories\ConversationRepository;
use Launcher\Mercurius\Repositories\UserRepository;

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
        return response($conversation->all());
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
    public function show($recipient, Request $request, ConversationRepository $conversation, UserRepository $user)
    {
        $request->validate([
            'offset'   => 'required|numeric',
            'pagesize' => 'required|numeric',
        ]);
        $recipient = $user->find($recipient)->id;

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
    public function destroy($recipient, Request $request, ConversationRepository $conversation, UserRepository $user)
    {
        $owner = $request->user()->id;
        $recipient = $user->find($recipient)->id;

        return response($conversation->delete($owner, $recipient));
    }
}
