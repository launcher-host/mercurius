<?php

namespace Launcher\Mercurius\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Launcher\Mercurius\Contracts\User as UserContract;

class User extends Authenticatable implements UserContract
{
    public function getName(): string
    {
        return config('mercurius.fields.name', 'name');
    }

    public function getAvatar(): string
    {
        return config('mercurius.fields.avatar', 'avatar');
    }

    public function getSlug(): string
    {
        return config('mercurius.fields.slug', 'slug');
    }
}
