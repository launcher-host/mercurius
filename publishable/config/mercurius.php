<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mercurius Models
    |--------------------------------------------------------------------------
    |
    | Defines the models used with Mercurius, you can use this to extend your
    | project by placing your own class implementation.
    |
    */

    'models' => [
        'user'    => App\User::class,
        'message' => Launcher\Mercurius\Message::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | User Table Fields
    |--------------------------------------------------------------------------
    |
    | You can specify the column names for the user table. The `name` accepts
    | an array of fields, for building custom names with multiple columns.
    |
    */

    'fields' => [
        // e.g. using array of fields
        // 'name'   => ['first_name', 'last_name'],
        'name'   => 'name',
        'slug'   => 'slug',
        'avatar' => 'avatar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Display "is typing..."
    |--------------------------------------------------------------------------
    |
    | When typing a message, we can display a message to the receiver.
    |
    */

    //  WIP - https://github.com/launcher-host/mercurius/issues/11
    // 'display_user_is_typing' => true,

];
