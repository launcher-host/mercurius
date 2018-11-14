<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('mercurius.{slug}', function ($user, $slug) {
    return (string) $user->{config('mercurius.fields.slug')} === (string) $slug;
    // return true;
});
