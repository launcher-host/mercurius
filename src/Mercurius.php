<?php

namespace Launcher\Mercurius;

use Auth;

class Mercurius
{
    /**
     * Script variables used at the Front-end JavaScript.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return json_encode([
            'csrfToken'     => csrf_token(),
            'env'           => config('app.env'),
            'i18n'          => json_decode(file_get_contents(resource_path('lang/'.app()->getLocale().'/mercurius.json'))),
            'user'          => self::userSettings(),
            'pusherKey'     => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster'),
        ]);
    }

    /**
     * Return profile settings.
     *
     * @return array
     */
    public static function userSettings()
    {
        $user = Auth::user();

        return [
            'slug'        => $user->slug,
            'name'        => $user->name,
            'avatar'      => $user->avatar,
            'is_online'   => (bool) $user->is_online,
            'be_notified' => (bool) $user->be_notified,
            'dark_mode'   => true,  // This is saved at LocalStorage
        ];
    }

    /**
     * Return User id for a given slug or fails.
     *
     * @param int|string $val
     *
     * @return Illuminate\Database\Eloquent\Model;
     */
    public static function findUserOrFail(string $slug)
    {
        $userFqcn = config('mercurius.models.user');
        $usr = $userFqcn::where('slug', $slug)->firstOrFail();

        return $usr->id;
    }
}
