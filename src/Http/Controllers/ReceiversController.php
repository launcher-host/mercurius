<?php

namespace Launcher\Mercurius\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

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
     * @param Request $request
     *
     * @return JSON
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('q', '');

            $result = [
                'hits'  => [],
                'total' => 0,
            ];

            if ($query == '') {
                return response($result);
            }

            $_usr = config('mercurius.models.user');
            $_where = ['name', 'LIKE', '%'.$query.'%'];

            $result['total'] = $_usr::where(...$_where)->count();
            $result['hits'] = $_usr::select('id', 'name', 'avatar', 'is_online')
                                    ->where(...$_where)
                                    ->limit(6)
                                    ->get();

            return response($result);
        } catch (\Exception $e) {
            return [$e->getMessage()];
        }
    }
}
