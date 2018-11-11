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
        'user'         => App\User::class,
        'message'      => Launcher\Mercurius\Models\Message::class,
        'conversation' => Launcher\Mercurius\Models\Conversation::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | User Table Fields
    |--------------------------------------------------------------------------
    |
    | You can specify the name of the fields in the user table. The `name` will
    | accept a mixed parameter: array and string.
    |
    */

    'fields' => [
        // 'name'   => '[first_name, last_name]',
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

    'display_user_is_typing' => true,

];
