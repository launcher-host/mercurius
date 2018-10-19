<?php

namespace Launcher\Mercurius\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Launcher\Mercurius\Repositories\UserRepository;

class ReceiversController extends Controller
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
     * Search for receivers.
     *
     * @param Request        $request
     * @param UserRepository $userRepository
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function search(Request $request, UserRepository $userRepository): Response
    {
        if (($query = $request->input('q')) === null) {
            return response([
                'hits'  => [],
                'total' => 0,
            ]);
        }

        $paginator = $userRepository->search($query);

        $result = [
            'total' => $paginator->total(),
            'hits'  => $paginator->items(),
        ];

        return response($result);
    }
}
