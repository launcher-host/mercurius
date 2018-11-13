<?php

namespace Launcher\Mercurius\Http\Controllers;

use Illuminate\Http\Request;
use Launcher\Mercurius\Events\UserGoesActive;
use Launcher\Mercurius\Events\UserGoesInactive;
use Launcher\Mercurius\Events\UserStatusChanged;
use Launcher\Mercurius\Repositories\ConversationRepository;
use Launcher\Mercurius\Repositories\UserRepository;

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
    public function refresh(Request $request, UserRepository $user): array
    {
        try {
            return response($user->getSettings());
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
            $request->validate([
                'setting_key' => 'required|in:is_online,be_notified',
                'setting_val' => 'required|boolean',
            ]);

            $slug = config('mercurius.fields.slug');
            $_key = $request['setting_key'];
            $_val = $request['setting_val'];
            $user = $request->user();

            // Save changes
            $user->{$_key} = $_val;
            $result = $user->save();

            // If User changes his status (active/inactive)
            if ($_key === 'is_online') {
                // Fire event with new User status
                $eventName = $_val ? UserGoesActive::class : UserGoesInactive::class;
                event(new $eventName($user->{$slug}));

                // Broadcast event to the Users holding conversations with the
                // current User
                $newStatus = ($_val ? 'active' : 'inactive');
                broadcast(new UserStatusChanged($user->{$slug}, $newStatus))->toOthers();
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
    public function notifications(Request $request, ConversationRepository $conv)
    {
        try {
            return response($conv->notifications());
        } catch (\Exception $e) {
            return [$e->getMessage()];
        }
    }
}
