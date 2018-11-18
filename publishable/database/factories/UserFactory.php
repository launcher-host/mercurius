<?php

use Faker\Generator as Faker;

$factory->define(config('mercurius.models.user'), function (Faker $faker) {
    $fields = config('mercurius.user_field_names');
    $names  = [];

    // Try to generate "first_name" and "last_name", if defined in the config.
    foreach (array_flatten([$fields['name']]) as $name) {
        $names[$name] = in_array($name, ['first_name', 'last_name'])
                    ? $faker->{camel_case($name)}
                    : $faker->name;
    }

    return array_merge($names, [
        'email'                => $faker->unique()->safeEmail,
        $fields['slug']        => str_slug($names[0], '_'),
        $fields['avatar']      => 'vendor/mercurius/img/avatar/'.$avatar,
        $fields['is_online']   => (bool)rand(0,1),
        $fields['be_notified'] => (bool)rand(0,1),
        'email_verified_at'    => now(),
        'password'             => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token'       => str_random(10),
    ]);
});
