<?php

/*
|--------------------------------------------------------------------------
| Mercurius Routes
|--------------------------------------------------------------------------
|
| This file is where we define Mercurius routes.
|
*/

Route::group([
    'as'         => 'mercurius.',
    'namespace'  => '\Launcher\Mercurius\Http\Controllers',
    'middleware' => [
        // 'Mercurius',
        'web',
        'auth',
    ],
], function () {

    // Mercurius home
    Route::get('/messages', function () {
        return View('mercurius::mercurius');
    })->name('home');

    // User Profile
    Route::get('/profile/refresh', 'ProfileController@refresh');
    Route::get('/profile/notifications', 'ProfileController@notifications');
    Route::post('/profile', 'ProfileController@update');

    // Conversations
    Route::get('/conversations', 'ConversationsController@index');
    Route::get('/conversations/recipients', 'ConversationsController@recipients');
    Route::post('/conversations/{receiver}', 'ConversationsController@show');
    Route::delete('/conversations/{receiver}', 'ConversationsController@destroy');

    // Messages
    Route::post('/messages', 'MessagesController@send');
    Route::delete('/messages/{id}', 'MessagesController@destroy');

    // Find Receivers
    Route::post('/receivers', 'ReceiversController@search');

    // Dummy page example
    Route::get('/notification-page-sample', function () {
        return View('mercurius::example');
    })->name('example');
});
