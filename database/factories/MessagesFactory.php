<?php

use Faker\Generator as Faker;
use App\Message;

$factory->define(App\Message::class, function (Faker $faker) {

    $to = range(1,50);
    $from = range(1,50);

    return [
        'to' => 1,
        'from' => rand(1, 50),
        'message' => $faker->sentence
    ];
});
