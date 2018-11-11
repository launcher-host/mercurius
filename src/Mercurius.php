<?php

namespace Launcher\Mercurius;

use Launcher\Mercurius\Setup\ProvidesScriptVariables;

class Mercurius
{
    use ProvidesScriptVariables;

    /**
     * The Mercurius version.
     */
    public static $version = '1.0.0-alpha';

    /**
     * Return User id for a given slug or fails.
     *
     * @param int|string $val
     *
     * @return Illuminate\Database\Eloquent\Model;
     */
    public function findUserOrFail(string $slug)
    {
        $userFqcn = config('mercurius.models.user');
        $usr = $userFqcn::where('slug', $slug)->firstOrFail();

        return $usr->id;
    }
}
