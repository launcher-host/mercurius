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
        'conversation' => Launcher\Mercurius\Models\Conversation::class,
        'message'      => Launcher\Mercurius\Models\Message::class,
        'user'         => App\User::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Mercurius Table Names
    |--------------------------------------------------------------------------
    |
    */

    'table_names' => [
        'conversation_user' => 'mercurius_conversation_user',
        'conversations'     => 'mercurius_conversations',
        'messages'          => 'mercurius_messages',
        'users'             => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | User Field Names
    |--------------------------------------------------------------------------
    |
    | You can specify the column names for the user table. The `name` accepts
    | an array of fields, for building custom names with multiple columns.
    |
    */

    'user_field_names' => [
        // e.g. using array of fields
        // 'name'   => ['first_name', 'last_name'],
        'name'        => 'name',
        'slug'        => 'slug',
        'avatar'      => 'avatar',
        'is_online'   => 'is_online',
        'be_notified' => 'be_notified',
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
