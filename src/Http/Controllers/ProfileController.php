<?php

namespace Launcher\Mercurius\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Launcher\Mercurius\Events\UserOnlineStatus;
use Launcher\Mercurius\Facades\Mercurius;
use Launcher\Mercurius\Repositories\ConversationRepository;

class ProfileController extends Controller
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
     * Refresh user account returning settings.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request)
    {
        try {
            return response(Mercurius::userSettings());
        } catch (\Exception $e) {
            return [$e->getMessage()];
        }
    }

    /**
     * Update user setting.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $inp = $request->only('setting_key', 'setting_val');
            $_key = (string) $inp['setting_key'];
            $_val = (bool) $inp['setting_val'];
            $user = Auth::user();

            // Validate request
            $allowedSettings = ['is_online', 'be_notified'];
            if (!in_array($_key, $allowedSettings)) {
                return response(['success' => false]);
            }

            // Save changes
            $user->{$_key} = $_val;
            $result = $user->save();

            // When user status goes on/off line, we broadcast the change
            //
            if ($_key === 'is_online') {
                // broadcast(new UserOnlineStatus($user->id, $_val));
                broadcast(new UserOnlineStatus($user->id, $_val))->toOthers();
            }

            return response([$result]);
        } catch (\Exception $e) {
            return [$e->getMessage()];
        }
    }

    /**
     * Return user notifications for new messages.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function notifications(Request $request)
    {
        try {
            return response(ConversationRepository::notifications());
        } catch (\Exception $e) {
            return [$e->getMessage()];
        }
    }
}
