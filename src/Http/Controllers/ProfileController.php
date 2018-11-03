<?php

namespace Launcher\Mercurius\Http\Controllers;

use Illuminate\Http\Request;
use Launcher\Mercurius\Events\UserGoesActive;
use Launcher\Mercurius\Events\UserGoesInactive;
use Launcher\Mercurius\Events\UserStatusChanged;
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
            $user = $request->user();

            // Validate request
            $allowedSettings = ['is_online', 'be_notified'];
            if (!in_array($_key, $allowedSettings, true)) {
                return response(['success' => false]);
            }

            // Save changes
            $user->{$_key} = $_val;
            $result = $user->save();

            // If User changes his status (active/inactive)
            if ($_key === 'is_online') {
                // Fire event with new User status
                $eventName = $_val ? UserGoesActive::class : UserGoesInactive::class;
                event(new $eventName($user->id));

                // Broadcast event to the Users holding conversations with the
                // current User
                $newStatus = ($_val ? 'active' : 'inactive');
                broadcast(new UserStatusChanged($user->id, $newStatus))->toOthers();
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
