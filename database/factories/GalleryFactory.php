<?php

use Faker\Generator as Faker;

$factory->define(App\Gallery::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description' => $faker->text($maxNbChars = 400),
        'user_id' => App\User::all()->random()->id

    ];
});
