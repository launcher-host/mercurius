<?php

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Foundation\Auth\User;
use Launcher\Mercurius\Models\Message;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'message' => $faker->sentence,
        'sender_id' => factory(User::class),
        'receiver_id' => factory(User::class),
        'seen_at' => Carbon::now(),
        'deleted_by_sender' => false,
        'deleted_by_receiver' => false,
    ];
});
