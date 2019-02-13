<?php

namespace Launcher\Mercurius\Http\Controllers;

class PagesController extends Controller
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
    public function notificationPageSample()
    {
        return View('mercurius::example');
    }

}
