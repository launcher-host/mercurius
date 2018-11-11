<?php

namespace Launcher\Mercurius\Setup;

use Launcher\Mercurius\Repositories\UserRepository;

trait ProvidesScriptVariables
{
    /**
     * Return the script variables used at the Front-end.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return json_encode([
            'csrfToken'     => csrf_token(),
            'env'           => config('app.env'),
            'i18n'          => json_decode(file_get_contents(resource_path('lang/'.app()->getLocale().'/mercurius.json'))),
            'user'          => UserRepository::getSettings(),
            'pusherKey'     => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster'),
        ]);
    }
}
